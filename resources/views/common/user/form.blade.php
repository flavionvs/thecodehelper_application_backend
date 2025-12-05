<?php
if (!empty($data->id)) {
    $url = route(guardName() . '.user.update', [$data->id]);
    $submit_button = 'Update '.request()->role;
} else {
    $url = route(guardName() . '.user.store');
    $submit_button = 'Create '.request()->role;
}
$role_id = $data->myRole ? $data->myRole->role_id : 0;
?>
<form action="{{ $url }}" method="post" enctype="multipart/form-data" id="form">
    @csrf
    @if (!empty($data->id))
        @method('PUT')
    @endif
    <input type="hidden" name="role" value="{{request()->role}}">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-lg-3 text-lg-right">
                    <label for="">Name</label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" name="first_name" class="form-control" data-limit="10"
                        value="{{ $data->first_name }}">
                </div>

                <div class="col-lg-3 text-lg-right">
                    <label for="">Phone</label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="text" name="phone" class="form-control numeric" data-limit="10"
                        value="{{ $data->phone }}">
                </div>
                <div class="col-lg-3 text-lg-right">
                    <label for="">Email</label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="email" name="email" class="form-control numeric" data-limit="10"
                        value="{{ $data->email }}">
                </div>


                <div class="col-lg-3 text-lg-right">
                    <label for="">Country</label>
                </div>
                <div class="col-lg-9 mb-2">
                    <select name="country" class="form-control chosen">
                        <option value="">Select Country</option>
                        <option @if ($data->country == 'Afghanistan') selected @endif>Afghanistan</option>
                        <option @if ($data->country == 'Albania') selected @endif>Albania</option>
                        <option @if ($data->country == 'Algeria') selected @endif>Algeria</option>
                        <option @if ($data->country == 'Andorra') selected @endif>Andorra</option>
                        <option @if ($data->country == 'Angola') selected @endif>Angola</option>
                        <option @if ($data->country == 'Argentina') selected @endif>Argentina</option>
                        <option @if ($data->country == 'Armenia') selected @endif>Armenia</option>
                        <option @if ($data->country == 'Australia') selected @endif>Australia</option>
                        <option @if ($data->country == 'Austria') selected @endif>Austria</option>
                        <option @if ($data->country == 'Azerbaijan') selected @endif>Azerbaijan</option>
                        <option @if ($data->country == 'Bahrain') selected @endif>Bahrain</option>
                        <option @if ($data->country == 'Bangladesh') selected @endif>Bangladesh</option>
                        <option @if ($data->country == 'Belarus') selected @endif>Belarus</option>
                        <option @if ($data->country == 'Belgium') selected @endif>Belgium</option>
                        <option @if ($data->country == 'Belize') selected @endif>Belize</option>
                        <option @if ($data->country == 'Benin') selected @endif>Benin</option>
                        <option @if ($data->country == 'Bhutan') selected @endif>Bhutan</option>
                        <option @if ($data->country == 'Bolivia') selected @endif>Bolivia</option>
                        <option @if ($data->country == 'Bosnia and Herzegovina') selected @endif>Bosnia and Herzegovina</option>
                        <option @if ($data->country == 'Botswana') selected @endif>Botswana</option>
                        <option @if ($data->country == 'Brazil') selected @endif>Brazil</option>
                        <option @if ($data->country == 'Bulgaria') selected @endif>Bulgaria</option>
                        <option @if ($data->country == 'Canada') selected @endif>Canada</option>
                        <option @if ($data->country == 'China') selected @endif>China</option>
                        <option @if ($data->country == 'Colombia') selected @endif>Colombia</option>
                        <option @if ($data->country == 'Croatia') selected @endif>Croatia</option>
                        <option @if ($data->country == 'Cuba') selected @endif>Cuba</option>
                        <option @if ($data->country == 'Cyprus') selected @endif>Cyprus</option>
                        <option @if ($data->country == 'Czech Republic') selected @endif>Czech Republic</option>
                        <option @if ($data->country == 'Denmark') selected @endif>Denmark</option>
                        <option @if ($data->country == 'Egypt') selected @endif>Egypt</option>
                        <option @if ($data->country == 'Finland') selected @endif>Finland</option>
                        <option @if ($data->country == 'France') selected @endif>France</option>
                        <option @if ($data->country == 'Germany') selected @endif>Germany</option>
                        <option @if ($data->country == 'Greece') selected @endif>Greece</option>
                        <option @if ($data->country == 'Hong Kong') selected @endif>Hong Kong</option>
                        <option @if ($data->country == 'India') selected @endif>India</option>
                        <option @if ($data->country == 'Indonesia') selected @endif>Indonesia</option>
                        <option @if ($data->country == 'Iran') selected @endif>Iran</option>
                        <option @if ($data->country == 'Iraq') selected @endif>Iraq</option>
                        <option @if ($data->country == 'Ireland') selected @endif>Ireland</option>
                        <option @if ($data->country == 'Italy') selected @endif>Italy</option>
                        <option @if ($data->country == 'Japan') selected @endif>Japan</option>
                        <option @if ($data->country == 'Kuwait') selected @endif>Kuwait</option>
                        <option @if ($data->country == 'Lebanon') selected @endif>Lebanon</option>
                        <option @if ($data->country == 'Malaysia') selected @endif>Malaysia</option>
                        <option @if ($data->country == 'Mexico') selected @endif>Mexico</option>
                        <option @if ($data->country == 'Morocco') selected @endif>Morocco</option>
                        <option @if ($data->country == 'Netherlands') selected @endif>Netherlands</option>
                        <option @if ($data->country == 'New Zealand') selected @endif>New Zealand</option>
                        <option @if ($data->country == 'Nigeria') selected @endif>Nigeria</option>
                        <option @if ($data->country == 'Norway') selected @endif>Norway</option>
                        <option @if ($data->country == 'Pakistan') selected @endif>Pakistan</option>
                        <option @if ($data->country == 'Philippines') selected @endif>Philippines</option>
                        <option @if ($data->country == 'Poland') selected @endif>Poland</option>
                        <option @if ($data->country == 'Portugal') selected @endif>Portugal</option>
                        <option @if ($data->country == 'Qatar') selected @endif>Qatar</option>
                        <option @if ($data->country == 'Romania') selected @endif>Romania</option>
                        <option @if ($data->country == 'Russia') selected @endif>Russia</option>
                        <option @if ($data->country == 'Saudi Arabia') selected @endif>Saudi Arabia</option>
                        <option @if ($data->country == 'Singapore') selected @endif>Singapore</option>
                        <option @if ($data->country == 'South Africa') selected @endif>South Africa</option>
                        <option @if ($data->country == 'South Korea') selected @endif>South Korea</option>
                        <option @if ($data->country == 'Spain') selected @endif>Spain</option>
                        <option @if ($data->country == 'Sweden') selected @endif>Sweden</option>
                        <option @if ($data->country == 'Switzerland') selected @endif>Switzerland</option>
                        <option @if ($data->country == 'Thailand') selected @endif>Thailand</option>
                        <option @if ($data->country == 'Turkey') selected @endif>Turkey</option>
                        <option @if ($data->country == 'Ukraine') selected @endif>Ukraine</option>
                        <option @if ($data->country == 'United Arab Emirates') selected @endif>United Arab Emirates</option>
                        <option @if ($data->country == 'United Kingdom') selected @endif>United Kingdom</option>
                        <option @if ($data->country == 'United States') selected @endif>United States</option>
                        <option @if ($data->country == 'Vietnam') selected @endif>Vietnam</option>
                    </select>
                </div>

                <div class="col-lg-3 text-lg-right">
                    <label for="">Email</label>
                </div>
                <div class="col-lg-9 mb-2">
                    <input type="email" name="email" class="form-control" value="{{ $data->email }}"
                        autocomplete="off">
                </div>
                <div class="col-lg-3 text-lg-right">
                    <label for="">Password {{$data->id ? "(Optional)" : ""}}</label>
                </div>
                <div class="col-lg-9 mb-2">
                    <div class="position-relative">
                        <input type="password" name="password" class="form-control" id="password" value=""
                            autocomplete="off">
                        <i class="fa fa-eye eye"></i>
                    </div>                    
                </div>
            </div>
            @if(request()->role == 'Freelancer')
                <div class="row">
                    <div class="col-lg-3 text-lg-right">
                        <label for="">Professional Title</label>
                    </div>
                    <div class="col-lg-9 mb-2">
                        <input type="text" name="professional_title" class="form-control" data-limit="10"
                            value="{{ $data->professional_title }}">
                    </div>
                    <div class="col-lg-3 text-lg-right">
                        <label for="">Experience</label>
                    </div>                                                    
                    <div class="col-lg-9 mb-2">
                        <select name="experience" class="form-control chosen">
                            <option value="">Select Experience</option>
                            <option value="0-1 years" @if($data->experience == '0-1 years') selected @endif>0-1 years</option>
                            <option value="2-3 years" @if($data->experience == '2-3 years') selected @endif>2-3 years</option>
                            <option value="4-6 years" @if($data->experience == '4-6 years') selected @endif>4-6 years</option>
                            <option value="7+ years" @if($data->experience == '7+ years') selected @endif>7+ years</option>
                        </select>
                    </div>
                    <div class="col-lg-3 text-lg-right">
                        <label for="">Language</label>
                    </div>                                                    
                    <div class="col-lg-9 mb-2">
                        <select name="lang_id[]" class="form-control chosen" multiple>                            
                            <option value="">Select Language</option>
                            @foreach ($lang as $item)                                
                                <option value="{{ $item->id }}" @if(in_array($item->id, $data->userLang->pluck('lang_id')->toArray())) selected @endif>{{ $item->name }}</option>                           
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 text-lg-right">
                        <label for="">Programming Language</label>
                    </div>                                                    
                    <div class="col-lg-9 mb-2">
                        <select name="programming_language_id[]" class="form-control chosen" multiple>                            
                            <option value="">Select Language</option>
                            @foreach ($programming_language as $item)                                
                                <option value="{{ $item->id }}" @if(in_array($item->id, $data->userProgrammingLanguage->pluck('programming_language_id')->toArray())) selected @endif>{{ $item->name }}</option>                           
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3 text-lg-right">
                        <label for="">Timezone</label>
                    </div>                                                    
                    <div class="col-lg-9 mb-2">
                        <select name="timezone" class="form-control chosen" multiple>                            
                            <option value="GMT+1" @if($data->timezone == 'GMT+1') selected @endif>GMT+1</option>
                            <option value="GMT" @if($data->timezone == 'GMT') selected @endif>GMT</option>                            
                        </select>
                    </div>

                    <div class="col-lg-3 text-lg-right">
                        <label for="">About</label>
                    </div>
                    <div class="col-md-9 mb-2">                                  
                        <textarea name="about" class="summernote">{{$data->about}}</textarea>
                    </div>  
                </div>
            @endif
        </div>
        <div class="col-lg-12 text-left">
            <button type="submit" class="btn btn-primary btn form-btn float-right">{{ $submit_button }}</button>
        </div>
    </div>
</form>
<script>
    $(document).ready(function() {
        $('#generate-password').click(function() {
            generatePwd();
        });

        function generatePwd() {
            $('#password').val(Math.floor(Math.random() * 99999999) + 10000000);
        }
        $('.eye').click(function() {
            if ($('#password').attr('type') == 'password') {
                $(this).removeClass('fa-eye').addClass('fa-eye-slash');
                $('#password').attr('type', 'text');
            } else {
                $('#password').attr('type', 'password');
                $(this).addClass('fa-eye').removeClass('fa-eye-slash');
            }
        });

        getOfficeDistricts();
        $('#office_state').change(function() {
            getOfficeDistricts();
        });

        function getOfficeDistricts() {
            let state_id = $('#office_state').val();
            let office_district_id = {{ $data->office_district_id ? $data->office_district_id : 0 }};
            $.ajax({
                url: '{{ url(guardName() . '/get-districts') }}/' + state_id + '/' + office_district_id,
                success: function(res) {
                    $('#office_district').html(res);
                }
            })
        }
    });
</script>
