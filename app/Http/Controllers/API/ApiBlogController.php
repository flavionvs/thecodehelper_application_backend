<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ApiBlogController extends Controller
{
    /**
     * List published blog posts (public)
     */
    public function index(Request $request)
    {
        $query = BlogPost::published()->orderBy('published_at', 'desc');

        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $posts = $query->paginate($request->get('per_page', 12));

        return response()->json([
            'status' => true,
            'data' => $posts,
        ]);
    }

    /**
     * Get single published blog post by slug (public)
     */
    public function show($slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->first();

        if (!$post) {
            return response()->json([
                'status' => false,
                'message' => 'Blog post not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $post,
        ]);
    }

    /**
     * Get all blog categories (public)
     */
    public function categories()
    {
        $categories = BlogPost::published()
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        return response()->json([
            'status' => true,
            'data' => $categories,
        ]);
    }

    /**
     * Create a new blog post (authenticated - admin only)
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'cover_image' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,published',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $slug = Str::slug($request->title);
        $originalSlug = $slug;
        $counter = 1;
        while (BlogPost::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $post = BlogPost::create([
            'title' => $request->title,
            'slug' => $slug,
            'excerpt' => $request->excerpt,
            'content' => $request->content,
            'cover_image' => $request->cover_image,
            'author' => $request->author ?? 'The Code Helper',
            'category' => $request->category,
            'tags' => $request->tags,
            'meta_title' => $request->meta_title ?? $request->title,
            'meta_description' => $request->meta_description ?? $request->excerpt,
            'status' => $request->status ?? 'draft',
            'published_at' => $request->status === 'published' ? now() : null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Blog post created successfully.',
            'data' => $post,
        ], 201);
    }

    /**
     * Update a blog post (authenticated)
     */
    public function update(Request $request, $id)
    {
        $post = BlogPost::find($id);
        if (!$post) {
            return response()->json(['status' => false, 'message' => 'Blog post not found.'], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'excerpt' => 'nullable|string|max:500',
            'cover_image' => 'nullable|string|max:500',
            'author' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:100',
            'tags' => 'nullable|array',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,published',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422);
        }

        $data = $request->only([
            'title', 'content', 'excerpt', 'cover_image', 'author',
            'category', 'tags', 'meta_title', 'meta_description', 'status',
        ]);

        // If title changed, regenerate slug
        if (isset($data['title']) && $data['title'] !== $post->title) {
            $slug = Str::slug($data['title']);
            $originalSlug = $slug;
            $counter = 1;
            while (BlogPost::where('slug', $slug)->where('id', '!=', $post->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
            $data['slug'] = $slug;
        }

        // Set published_at if transitioning to published
        if (isset($data['status']) && $data['status'] === 'published' && !$post->published_at) {
            $data['published_at'] = now();
        }

        $post->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Blog post updated successfully.',
            'data' => $post->fresh(),
        ]);
    }

    /**
     * Delete a blog post (authenticated)
     */
    public function destroy($id)
    {
        $post = BlogPost::find($id);
        if (!$post) {
            return response()->json(['status' => false, 'message' => 'Blog post not found.'], 404);
        }

        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'Blog post deleted successfully.',
        ]);
    }

    /**
     * Sitemap data — returns all published posts for sitemap generation
     */
    public function sitemap()
    {
        $posts = BlogPost::published()
            ->select('slug', 'updated_at', 'published_at')
            ->orderBy('published_at', 'desc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $posts,
        ]);
    }
}
