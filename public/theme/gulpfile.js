var gulp = require('gulp');
const sass = require('gulp-sass')(require('sass'));
postcss = require("gulp-postcss");
autoprefixer = require("autoprefixer");
var sourcemaps = require('gulp-sourcemaps'); 
var browserSync = require('browser-sync').create(); 
cssbeautify = require('gulp-cssbeautify');
var beautify = require('gulp-beautify');



/*******************  LTR   ******************/

//_______ task for scss folder to css main style 
gulp.task('watch', function() {
	console.log('Command executed successfully compiling SCSS in assets.');
	 return gulp.src('assets/scss/**/*.scss') 
		.pipe(sourcemaps.init())                       
		.pipe(sass())
		.pipe(sourcemaps.write(''))   
		.pipe(gulp.dest('assets/css'))
		.pipe(browserSync.reload({
		  stream: true
	}))
})

//_______task for style Boxed
gulp.task('boxed', function(){
   return gulp.src('assets/css/boxed.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style dark
gulp.task('dark', function(){
   return gulp.src('assets/css/dashboard-dark.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style dark-boxed
gulp.task('dark-boxed', function(){
   return gulp.src('assets/css/dark-boxed.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style color
gulp.task('color', function(){
   return gulp.src('assets/css/color.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style Skins
gulp.task('skins', function(){
   return gulp.src('assets/css/style-modes.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style Horizontal
gulp.task('hor', function(){
   return gulp.src('assets/css/horizontal-menu.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style Horizontal dark
gulp.task('hor-dark', function(){
   return gulp.src('assets/css/horizontal-menu-dark.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style Sidemenu
gulp.task('sidemenu', function(){
   return gulp.src('assets/css/sidemenu/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css/sidemenu'));
		
});


//_______task for skins
gulp.task('color-skins', function(){
   return gulp.src('assets/skins/skins-modes/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/skins/skins-modes'));
		
})

/*******************  LTR-Beautify  ******************/

//_______ task for beautifying css
gulp.task('beautify', function() {
    return gulp.src('assets/css/*.css')
        .pipe(beautify.css({ indent_size: 4 }))
        .pipe(gulp.dest('assets/css'));
});

/*******************  RTL   ******************/

//_______ task for scss folder to css main style 
gulp.task('rtl-watch', function() {
	console.log('Command executed successfully compiling SCSS in assets.');
	 return gulp.src('assets/scss-rtl/**/*.scss') 
		.pipe(sourcemaps.init())                       
		.pipe(sass())
		.pipe(sourcemaps.write(''))   
		.pipe(gulp.dest('assets/css-rtl'))
		.pipe(browserSync.reload({
		  stream: true
	}))
})

//_______task for style Boxed
gulp.task('rtl-boxed', function(){
   return gulp.src('assets/css-rtl/boxed.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css-rtl'));
		
});

//_______task for style dark
gulp.task('rtl-dark', function(){
   return gulp.src('assets/css-rtl/dashboard-dark.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css-rtl'));
		
});

//_______task for style dark-boxed
gulp.task('rtl-dark-boxed', function(){
   return gulp.src('assets/css-rtl/dark-boxed.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css-rtl'));
		
});

//_______task for style color
gulp.task('rtl-color', function(){
   return gulp.src('assets/css-rtl/color.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css-rtl'));
		
});

//_______task for style Skins
gulp.task('rtl-skins', function(){
   return gulp.src('assets/css-rtl/style-modes.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});

//_______task for style Horizontal
gulp.task('rtl-hor', function(){
   return gulp.src('assets/css-rtl/horizontal-menu-rtl.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css'));
		
});


//_______task for style Sidemenu
gulp.task('rtl-sidemenu', function(){
   return gulp.src('assets/css-rtl/sidemenu/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(sass())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('assets/css-rtl/sidemenu'));
		
});

/*******************  RTL-Beautify  ******************/

//_______ task for beautifying css
gulp.task('rtl-beautify', function() {
    return gulp.src('assets/css-rtl/*.css')
        .pipe(beautify.css({ indent_size: 4 }))
        .pipe(gulp.dest('assets/css-rtl'));
});