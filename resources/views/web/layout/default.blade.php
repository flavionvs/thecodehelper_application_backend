<!DOCTYPE html>
<html lang="en" style="max-width: 100%;overflow-x: hidden;">
<head>
    <script>
        let GUARD_NAME = '';
    </script>
    <meta name="theme-color" content="#ffffff">
    <title>{{config('constant.app_name')}} </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css' rel='stylesheet'>

    <script type='text/javascript' src=''></script>
    <script type='text/javascript' src='https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js'></script>
    </script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="{{ asset('meeting/css/style.css') }}">

    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/1.0.7/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
</head>

<body>

    @yield('content')


    <script type='text/javascript'></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
   
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/1.0.7/js/dataTables.responsive.min.js"></script>


    <!-- Data Aos -->
    {{-- <script src="https://unpkg.com/aos@next/dist/aos.js"></script> --}}
    <script>
        AOS.init();
    </script>

    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

    <!-- Initialize Swiper -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options = {
                "positionClass": "toast-top-right",
                "closeButton": true,
                "debug": false,
                "newestOnTop": true,
                "progressBar": true,
                "preventDuplicates": true,
                "preventOpenDuplicates": true,
                "onclick": null,
                "showDuration": "1000",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "5000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            }
            @if (session()->get('success'))
                toastr.success("{{ session()->get('success') }}");
            @endif
            @if (session()->get('info'))
                toastr.info("{{ session()->get('info') }}");
            @endif
            @if (session()->get('warning'))
                toastr.warning("{{ session()->get('warning') }}");
            @endif
            @if (session()->get('error'))
                toastr.error("{{ session()->get('error') }}");
            @endif
            @if ($errors->all())
                @foreach ($errors->all() as $error)
                    toastr.error("{{ $error }}");
                @endforeach
            @endif
            $('#myTable').DataTable();
            $('.numeric').on('input', function() {
                $(this).val($(this).val().replace(/[^0-9\.]/g, ''));
                var limit = $(this).data('limit');
                if (limit != undefined) {
                    if ($(this).val().length > limit) {
                        $(this).val($(this).val().slice(0, limit));
                    }
                }
                var max = $(this).data('max');
                if (max != undefined) {
                    if ($(this).val() > max) {
                        $(this).val(max);
                    }
                }
                if ($(this).val() < 0) {
                    $(this).val('0');
                }
            });
            $('.booking-btn').click(function() {
                let room_id = $(this).data('id');
                $.ajax({
                    url: '{{ url('get-room-booking-form') }}/' + room_id,
                    success: function(res) {
                        $('#bookingForm2').html(res);
                        capacityChange(room_id);
                        $('#capacity').on('change', function() {
                            showLoader();
                            capacityChange();
                        })
                    }
                })
            })
            $('.btn-meeting').click(function() {
                $.ajax({
                    url: '{{ url('get-booking-form') }}',
                    success: function(res) {
                        $('#bookingForm2').html(res);
                        $('#capacity').on('change', function() {
                            showLoader();
                            capacityChange();
                        })
                    }
                })
            })

            function capacityChange(room_id = '') {
                let capacity = $('#capacity').val();
                let _room_id = room_id
                $('#addons').html('');
                $.ajax({
                    url: '{{ url('get-rooms') }}',
                    data: {
                        capacity: capacity,
                        room_id: _room_id
                    },
                    success: function(res) {
                        $('#rooms').html(res);
                        getAddOn(_room_id);
                        hideLoader();
                    }
                })
            }

            function getAddOn(room_id = '') {
                let __room_id = room_id;
                $('#room').change(function() {
                    let room_id = $('#room').val();
                    changeRooms(room_id);
                })
                changeRooms(__room_id);
            }

            function changeRooms(room_id) {
                showLoader();
                let _room_id = room_id;
                $.ajax({
                    url: '{{ url('get-addon') }}',
                    data: {
                        room_id: room_id
                    },
                    success: function(res) {
                        $('#addons').html(res.addon_details);
                        $('#room-details').html(res.room_details);
                        changeBookingDate();
                        $('#bookingDate').off().change(function() {
                            changeBookingDate();
                        });
                        hideLoader();
                    }
                })
            }
            $('.room-btn').click(function() {
                showLoader();
                let room_id = $(this).data('id');
                $.ajax({
                    url: '{{ url('get-room-booking-details') }}/' + room_id,
                    success: function(res) {
                        $('#roomDetails').html(res);
                        changeBookingDate();
                        $('#bookingDate').change(function() {
                            changeBookingDate();
                        });
                        hideLoader();
                    }
                })
            })

            function changeBookingDate() {
                showLoader();
                $('.error').html('');
                $('#bookingTable').html('');
                $('#bookingDate').attr('disabled', true);
                let date = $('#bookingDate').val();
                let room_id = $('#room_id').val();
                $.ajax({
                    url: '{{ url('get-date-wise-booking') }}',
                    data: {
                        date: date,
                        room_id: room_id
                    },
                    success: function(res) {
                        if(res.status == true){
                            $('#bookingTable').html(res.output);
                        }else{                            
                            $('.error').html(res.message)                        
                        }
                        $('#bookingDate').attr('disabled', false);
                        hideLoader();
                    }
                })
            }
            setInterval(() => {
                $('.status').map(function() {
                    var startTime = $(this).data('date') + ' ' + $(this).data('from-time');
                    var endTime = $(this).data('date') + ' ' + $(this).data('to-time');
                    var currentDate = new Date();
                    var compareStartDate = new Date(startTime)
                    var compareEndDate = new Date(endTime)
                    if (compareEndDate <=
                        currentDate) {
                        $(this).html('{!! status('Ended') !!}');
                        $(this).next('.feedback').children('button').attr('disabled', false);
                    } else if (compareStartDate <= currentDate && compareEndDate >=
                        currentDate) {
                        $(this).html('{!! status('Running') !!}');
                    }

                }).get();
            }, 1000);
            // let i = 0;
            // setInterval(() => {
            //     $('.booked').map(function() {
            //         var startTime = $(this).data('date') + ' ' + $(this).data('from-time');
            //         var endTime = $(this).data('date') + ' ' + $(this).data('to-time');
            //         var currentDate = new Date();
            //         var compareStartDate = new Date(startTime)
            //         var compareEndDate = new Date(endTime)
            //         var timeDifference = (compareEndDate.getTime() - currentDate.getTime()) / 1000;
            //         timeDifference = parseInt(timeDifference);
            //         // console.log(timeDifference);
            //         if (compareStartDate.getTime() <= currentDate.getTime() && timeDifference < 900 && timeDifference > 0) {
            //             $(this).addClass('card-animate');
            //             var minutes = Math.floor(timeDifference / 60);
            //             var remainingSeconds = timeDifference % 60;
            //             $(this).find('#time-left').html('Left Time - ' + addLeadingZero(minutes) +
            //                 ':' +
            //                 addLeadingZero(remainingSeconds) +
            //                 ' secs. ');
            //                 i++;
            //                 console.log('in');
            //             $(this).removeClass('card-animate').css('background-color', 'red');
            //         } else if (compareStartDate.getTime() <= currentDate.getTime() && compareEndDate >=
            //             currentDate) {
            //                 i++;
            //                 console.log('in');
            //             $(this).removeClass('card-animate').css('background-color', 'red');
            //         } else {
            //             i = 0;
            //             console.log('de');
            //             $(this).removeClass('card-animate').css('background-color', 'green');
            //             $(this).find('#time-left').html('');
            //         }
                    
            //     }).get();
            //     console.log(i);
            // }, 1000);

            function addLeadingZero(number) {
                if (number < 10) {
                    return "0" + number;
                } else {
                    return number;
                }
            }

            // // console.log('hello');
            // let room_details = document.getElementById('myTable');
            // room_details.style.display = "none";
            // let all_room_details = document.getElementById('all_room_table');
            // all_room_details.style.display = 'block';
            // $('#rooms').change(function() {
            //     let value = $(this).val();
            //     console.log(value);

            //     if (value !== 'All room') {
            //         room_details.style.display = "table";
            //         all_room_details.style.display = 'none';
            //     } else {
            //         room_details.style.display = "none";
            //         all_room_details.style.display = 'block';
            //     }

            // });


            function show_modal(modal_id) {
                $(modal_id).modal("show");
            }
        });

        function showLoader() {
            $('#ftco-loader').show();
        }

        function hideLoader() {
            $('#ftco-loader').hide();
        }

        var swiper = new Swiper(".mySwiper", {
            loop: true,
            breakpoints: {
                1000: {
                    slidesPerView: 4,
                    spaceBetween: 30,
                },
                768: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
                680: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                480: {
                    slidesPerView: 1,
                    spaceBetween: 10,
                },
            },
            // autoplay: {
            // 	delay: 2000,
            // },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });






        var gallery = new SimpleLightbox('.gallery a', {
            animationSlide: true,
            preloading: true,
            enableKeyboard: true,
            doubleTapZoom: 2,
            maxZoom: 10,
            fadeSpeed: 300,
            close: true,
            navText: ['&larr;', '&rarr;'],
            nav: true,
            spinner: true,
            overlay: true,

        });

        function openClose() {
            var x = document.getElementById("menu_open_close");
            if (x.style.display === "block") {
                x.style.display = "none";
            } else {
                x.style.display = "block";
            }
        }
        hideLoader();
    </script>

</body>

</html>
