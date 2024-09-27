@extends('layouts.master')
@section('title')
    Yönetici Paneli
@endsection
@section('page-title')
    Yönetici Paneli
@endsection
@section('body')

    <body data-sidebar="colored">
    @endsection
    @section('content')
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex mb-4 justify-content-between" >
                            <h5 class="card-title ">Kullanıcı Adı Soyadı</h5>
                        </div>
                        <div class="chat-leftsidebar me-4">
                            <div class="card mb-0">
                                <div class="chat-leftsidebar-nav">
                                    <ul class="nav nav-pills nav-justified bg-light-subtle" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <a href="#genelbilgi" data-bs-toggle="tab" aria-expanded="false" class="nav-link " aria-selected="false" role="tab">
                                                <i class="ri-message-2-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Temel Bilgiler</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#analiz" data-bs-toggle="tab" aria-expanded="true" class="nav-link" aria-selected="false" role="tab" tabindex="-1">
                                                <i class="ri-message-2-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Analiz</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#takvim" data-bs-toggle="tab" aria-expanded="false" class="nav-link active " aria-selected="true" role="tab">
                                                <i class="ri-message-2-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Takvim</span>
                                            </a>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <a href="#dosyalar" data-bs-toggle="tab" aria-expanded="false" class="nav-link " aria-selected="false" role="tab">
                                                <i class="ri-message-2-line font-size-20"></i>
                                                <span class="mt-2 d-none d-sm-block">Dosyalar</span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tab-content pt-4">
                                <div class="tab-pane" id="genelbilgi" role="tabpanel">
                                    <div>
                                        <div class="card">
                                            <div class="card-header">
                                                Kişisel Bilgiler
                                            </div>
                                            <div class="card-body">
                                                <blockquote class="card-blockquote mb-0">
                                                    <div class="row">
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input disabled type="text" class="form-control" name="name" id="floatingFirstnameInput" value="{{$user->name}}">
                                                                <label for="floatingFirstnameInput">Ad Soyad</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input disabled type="text" class="form-control" name="proje_adi" id="floatingFirstnameInput" value="{{$user->email}}" placeholder="Proje Adı Giriniz">
                                                                <label for="floatingFirstnameInput">Eposta Adresi</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input disabled type="text" class="form-control" name="proje_adi" id="floatingFirstnameInput" value="{{$user->phone_number}}" placeholder="Proje Adı Giriniz">
                                                                <label for="floatingFirstnameInput">Cep Telefonu</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-sm-12">
                                                            <div class="form-floating mb-3">
                                                                <input disabled type="text" class="form-control" name="proje_adi" id="floatingFirstnameInput" value="{{$user->departman->baslik}}" placeholder="Proje Adı Giriniz">
                                                                <label for="floatingFirstnameInput">Departman Adı</label>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </blockquote>
                                            </div>
                                        </div>
                                        <div class="card">
                                            <div class="card-header">
                                                Ekipler
                                            </div>
                                        <div class="card-body">
                                            <blockquote class="card-blockquote mb-0">
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>Ekip Adı</th>
                                                    <th>Katılım Tarihi</th>
                                                    <th>İşlem</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($user->ekipUyeleri as $ekipler)
                                                    <tr>
                                                        <td>{{$ekipler->ekip->baslik}}</td>
                                                        <td>{{$ekipler->created_at}}</td>
                                                        <td>
                                                            <div class="dropdown">
                                                                <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    <button type="button" class="btn btn-primary waves-effect waves-light">
                                                                        İşlemler <i class="mdi mdi-dots-vertical"></i>
                                                                    </button>
                                                                </a>

                                                                <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-40px, 30px, 0px);" data-popper-placement="bottom-end">
                                                                    <a class="dropdown-item" href="{{route('panel-squad-details',['id'=>$ekipler->ekip->id])}}">İncele</a>
                                                                    <a class="dropdown-item" href="{{route('panel-squad-edit',['id'=>$ekipler->ekip->id])}}">Düzenle</a>
                                                                    <div class="dropdown-divider"></div>
                                                                    <a class="dropdown-item" href="#">Üyeyi Ekipten Çıkar</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                @endforeach
                                                </tbody>
                                            </table>
                                            </blockquote>
                                        </div>
                                    </div>
                                        <div class="card">
                                            <div class="card-header">
                                                İşler
                                            </div>
                                        <div class="card-body">
                                            <blockquote class="card-blockquote mb-0">
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                                   style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                <thead>
                                                <tr>
                                                    <th>İş Adı</th>
                                                    <th>Proje adı</th>
                                                    <th>Başlama Tarihi</th>
                                                    <th>Bitirme Tarihi</th>
                                                    <th>Öncelik</th>
                                                    <th>Durumu</th>
                                                    <th>İşlem</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($user->isSahiplikleri as $is)
                                                        <tr>
                                                            <td>{{$is->work->baslik}}</td>
                                                            <td>{{$is->work->proje->baslik}}</td>
                                                            <td>{{$is->work->baslangic_tarihi}}</td>
                                                            <td>{{$is->work->bitis_tarihi}}</td>
                                                            <td><span class="badge badge-soft-danger font-size-12">{{$is->work->oncelik}}</span></td>
                                                            <td>
                                                                    @switch($is->oncelik)
                                                                        @case(0)
                                                                            <span class="badge badge-soft-warning font-size-12">Pasif</span>
                                                                            @break
                                                                        @case(1)
                                                                        <span class="badge badge-soft-info font-size-12">Devam Ediyor</span>
                                                                            @break

                                                                        @case(2)
                                                                        <span class="badge badge-soft-success font-size-12">Tamamlandı</span>
                                                                            @break
                                                                    @endswitch
                                                            </td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <a class="text-muted dropdown-toggle font-size-20" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        <button type="button" class="btn btn-primary waves-effect waves-light">
                                                                            İşlemler <i class="mdi mdi-dots-vertical"></i>
                                                                        </button>
                                                                    </a>

                                                                    <div class="dropdown-menu dropdown-menu-end " style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate3d(-40px, 30px, 0px);" data-popper-placement="bottom-end">
                                                                        <a class="dropdown-item" href="{{route('panel-work-details',['id'=>$is->work->id])}}">İncele</a>
                                                                        <a class="dropdown-item" href="{{route('panel-work-edit',['id'=>$is->work->id])}}">Düzenle</a>
                                                                        <div class="dropdown-divider"></div>
                                                                        <a class="dropdown-item" href="#">Üyeyi İşten Al</a>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                <div class="tab-pane" id="analiz" role="tabpanel">
                                    <div>
                                        <h5 class="font-size-14 mb-2">Analiz</h5>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h4 class="card-title mb-4"> Kullanıcının İş Durumları</h4>
                                                        <div id="simple_pie_chart" class="apex-charts" dir="ltr"></div>
                                                    </div>
                                                </div>
                                                <!--end card-->
                                            </div>
                                            <!-- end col -->
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane  active show" id="takvim" role="tabpanel">
                                    <div>
                                        <div class="row mb-4">
                                            <div class="col-xl-3 d-none  ">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <button type="button" class="btn font-16 btn-primary waves-effect waves-light w-100"
                                                                id="btn-new-event" data-bs-toggle="modal" data-bs-target="#event-modal">
                                                            Create New Event
                                                        </button>

                                                        <div id="external-events">
                                                            <br>
                                                            <p class="text-muted">Drag and drop your event or click in the calendar</p>
                                                            <div class="external-event fc-event bg-success" data-class="bg-success">
                                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>New Event
                                                                Planning
                                                            </div>
                                                            <div class="external-event fc-event bg-info" data-class="bg-info">
                                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Meeting
                                                            </div>
                                                            <div class="external-event fc-event bg-warning" data-class="bg-warning">
                                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Generating
                                                                Reports
                                                            </div>
                                                            <div class="external-event fc-event bg-danger" data-class="bg-danger">
                                                                <i class="mdi mdi-checkbox-blank-circle font-size-11 me-2"></i>Create
                                                                New theme
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div> <!-- end col-->
                                            <div class="col-xl-12">
                                                <div class="card mb-0">
                                                    <div class="card-body">
                                                        <div style="height: 800px" id="calendar"></div>
                                                    </div>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->
                                        <div style='clear:both'></div>

                                        <!-- Add New Event MODAL -->
                                        <div class="modal fade" id="event-modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                             aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header py-3 px-4">
                                                        <h5 class="modal-title" id="modal-title">Event</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body p-4">
                                                        <form class="needs-validation" name="event-form" id="form-event" novalidate>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Event Name</label>
                                                                        <input class="form-control" placeholder="Insert Event Name" type="text"
                                                                               name="title" id="event-title" required value="">
                                                                        <div class="invalid-feedback">Please provide a valid event name
                                                                        </div>
                                                                    </div>
                                                                </div> <!-- end col-->
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Category</label>
                                                                        <select class="form-select" name="category" id="event-category">
                                                                            <option selected> --Select-- </option>
                                                                            <option value="bg-danger">Danger</option>
                                                                            <option value="bg-success">Success</option>
                                                                            <option value="bg-primary">Primary</option>
                                                                            <option value="bg-info">Info</option>
                                                                            <option value="bg-dark">Dark</option>
                                                                            <option value="bg-warning">Warning</option>
                                                                        </select>
                                                                        <div class="invalid-feedback">Please select a valid event
                                                                            category</div>
                                                                    </div>
                                                                </div> <!-- end col-->
                                                            </div> <!-- end row-->
                                                            <div class="row mt-2">
                                                                <div class="col-6">
                                                                    <button type="button" class="btn btn-danger" id="btn-delete-event">Delete</button>
                                                                </div> <!-- end col-->
                                                                <div class="col-6 text-end">
                                                                    <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                                                    <button type="submit" class="btn btn-success" id="btn-save-event">Save</button>
                                                                </div> <!-- end col-->
                                                            </div> <!-- end row-->
                                                        </form>
                                                    </div>
                                                </div>
                                                <!-- end modal-content-->
                                            </div>
                                            <!-- end modal dialog-->
                                        </div>                                    </div>
                                </div>
                                <div class="tab-pane" id="dosyalar" role="tabpanel">
                                    <h5 class="font-size-14 mb-2">Dosyalar</h5>

                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap"
                                           style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                        <tr>
                                            <th>Dosya Adı</th>
                                            <th>Eklenme Tarihi</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td><i class="mdi mdi-file-document font-size-16 align-middle text-primary me-2"></i> Dosya Adı</td>
                                            <td>01.01.2020</td>
                                        </tr>
                                        </tbody>
                                    </table>

                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    @endsection
    @section('scripts')
        <!-- App js -->
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <script src="{{ URL::asset('public/build/js/app.js') }}"></script>
        <script src="{{ URL::asset('staj/public/build/libs/apexcharts/apexcharts.min.js') }}"></script>
        <script src="{{ URL::asset('staj/public/build/libs/fullcalendar/index.global.min.js') }}"></script>
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>

        <!-- Kullanıcının İş Durumları yapilandirmasi -->
        <script>
            $(document).ready(function() {
                $('.js-example-basic-single').select2();

                var result1 = @json($analiz1);
                var options = {
                    series: result1,
                    chart: {
                        height: 300,
                        type: 'pie',
                    },
                    labels: ['Devam Ediyor', 'Tamamlandı'],
                    legend: {
                        position: 'bottom'
                    },
                    dataLabels: {
                        dropShadow: {
                            enabled: false,
                        }
                    },
                    colors: ['#086070', '#38c786', '#2651e9']
                };

                var chart = new ApexCharts(document.querySelector("#simple_pie_chart"), options);
                chart.render();
            });
        </script>
        <!-- Takvim yapilandirmasi -->
        <script >
            document.getElementById('event-modal');
            var modalTitle = document.getElementById('modal-title');
            var formEvent = document.getElementById('form-event');
            var selectedEvent = null;
            var newEventData = null;
            var forms = document.getElementsByClassName('needs-validation');
            var selectedEvent = null;
            var newEventData = null;
            var eventObject = null;
            /* initialize the calendar */

            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var Draggable = FullCalendar.Draggable;
            var externalEventContainerEl = document.getElementById('external-events');

            // init dragable
            new Draggable(externalEventContainerEl, {
                itemSelector: '.external-event',
                eventData: function (eventEl) {
                    return {
                        title: eventEl.innerText,
                        start: new Date(),
                        className: eventEl.getAttribute('data-class')
                    };
                }
            });


            var defaultEvents = [

            ];

            var draggableEl = document.getElementById('external-events');
            var calendarEl = document.getElementById('calendar');

            function addNewEvent(info) {
                addEvent.show();
                formEvent.classList.remove("was-validated");
                formEvent.reset();
                selectedEvent = null;
                modalTitle.innerText = 'Add Event';
                newEventData = info;
            }

            function getInitialView() {
                if (window.innerWidth >= 768 && window.innerWidth < 1200) {
                    return 'timeGridWeek';
                } else if (window.innerWidth <= 768) {
                    return 'listMonth';
                } else {
                    return 'dayGridMonth';
                }
            }

            var calendar = new FullCalendar.Calendar(calendarEl, {
                timeZone: 'tr',
                locale:'tr',
                editable: false,
                droppable: false,
                selectable: false,
                initialView: getInitialView(),
                themeSystem: 'bootstrap',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                buttonText: {
                    today: 'Bugün',
                    month: 'Ay',
                    week: 'Hafta',
                    day: 'Gün'
                },
                // responsive
                windowResize: function (view) {
                    var newView = getInitialView();
                    calendar.changeView(newView);
                },
                eventDidMount: function (info) {
                    if (info.event.extendedProps.status === 'done') {

                        // Change background color of row
                        info.el.style.backgroundColor = 'red';

                        // Change color of dot marker
                        var dotEl = info.el.getElementsByClassName('fc-event-dot')[0];
                        if (dotEl) {
                            dotEl.style.backgroundColor = 'white';
                        }
                    }
                },
                dateClick: function (info) {
                    document.getElementById("btn-delete-event").style.display = "none";
                    addNewEvent(info);
                },
                events: defaultEvents
            });

            /*Add new event*/
            // Form to add new event

            formEvent.addEventListener('submit', function (ev) {
                ev.preventDefault();

                var updatedTitle = document.getElementById("event-title").value;
                var updatedCategory = document.getElementById('event-category').value;

                // validation
                if (forms[0].checkValidity() === false) {
                    forms[0].classList.add('was-validated');
                } else {
                    if (selectedEvent) {
                        selectedEvent.setProp("title", updatedTitle);
                        selectedEvent.setProp("classNames", [updatedCategory]);
                    } else {
                        var newEvent = {
                            title: updatedTitle,
                            start: newEventData.date,
                            allDay: newEventData.allDay,
                            className: updatedCategory
                        };
                        calendar.addEvent(newEvent);
                    }
                    addEvent.hide();
                }
            });

            document.getElementById("btn-delete-event").addEventListener("click", function (e) {
                if (selectedEvent) {
                    selectedEvent.remove();
                    selectedEvent = null;
                    selectedEvent.hide();
                }
            });
            $(document).ready(function() {
                calendar.render();
            });
        </script>
@endsection
