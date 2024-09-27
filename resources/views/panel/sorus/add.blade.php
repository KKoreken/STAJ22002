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
                <form action="{{route('soru.store')}}" method="post" enctype="multipart/form-data">@csrf

                    <div class="card">
                            <div class="mt card-body">
                                <div class="d-flex mb-4 justify-content-between">
                                    <h5 class="card-title">Yeni İş Ekle</h5>
                                    <button class="btn px-5 btn-primary" id="submitForm">Onayla</button>
                                </div>

                                    <div class="chat-leftsidebar me-4">


                             <div class="tab-content pt-4">
                                <div class="tab-pane active show" id="isler" role="tabpanel">
                                    <div class="my-2">
                                        <div class="row">
                                            <div class="col-xl-7 my-2 col-md-12 ">
                                                <div class="form-floating mb-3">
                                                    <input required type="text" class="form-control" name="baslik" id="floatingFirstnameInput" placeholder="Enter Your First Name">
                                                    <label for="floatingFirstnameInput">Soru Adı</label>
                                                </div>
                                            </div>
                                            <div class="col-xl-7 my-2 col-md-12">
                                                <label for="oncelik">Soru Tipi </label>
                                                <select onchange="typeCheck();" id="type"  style="width: 100%" class="js-example-basic-single form-control" name="type">
                                                    <option value="text">Metin</option>
                                                    <option value="email">Eposta Adresi</option>
                                                    <option value="date">Tarih</option>
                                                    <option value="number">Numara</option>
                                                    <option value="email">Eposta</option>
                                                    <option value="select">Seçenek</option>
                                                    <option value="checkbox">Kutucuk</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div id="attributeDiv" >
                                            <!-- Select icin div -->
                                            <div id="selectdiv" class="select-options attribute-div d-none">
                                                <div class="row border  " >
                                                    <h3 class="my-2">Seçenek Detayları</h3>
                                                    <!-- Optionlar -->

                                                    <div class="row py-2">
                                                        <div class="col-md-3">
                                                            <button type="button" id="addOptionButton" class="btn btn-primary mb-2">Seçenek Ekle</button>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="table-responsive mt-3">
                                                                <table class="table table-hover" id="candidateTable">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <div class="dropdown-sort">
                                                                                <span>Soru Adı</span>
                                                                            </div>
                                                                        </th>

                                                                        <th>
                                                                            <div class="dropdown-sort">
                                                                                <span>İşlem</span>
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                    </thead>

                                                                    <tbody id="candidateTableBody">

                                                                    </tbody>                                          </table>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <!-- Attributelar -->
                                                    <div class="row">

                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Kutucuk icin div -->
                                            <div id="checkboxdiv" class="select-options  attribute-div d-none">
                                                <label for="checkboxTitle" class="form-label">Kutucuk Tipi</label>
                                                <select name="options[]" id="checkboxTypeSelect">
                                                    <option selected >Seçiniz</option>
                                                    <option  value="modal">Açılır Pencere</option>
                                                    <option  value="link">link</option>
                                                </select>
                                                <div id="checkboxLinkDiv" class="d-none">
                                                    <div class="card border">
                                                        <label for="checkboxTitle" class="form-label">Açılan Link</label>
                                                        <input  name='options[]' type="text" class="form-control" id="checkboxTitle"
                                                                placeholder="Başlık bilgisi giriniz..">
                                                    </div>
                                                </div>
                                                <div id="checkboxModalDiv" class="d-none" >
                                                    <div class="card border">
                                                        <label for="checkboxTitle" class="form-label">Açılan Pencere Başlığı</label>
                                                        <input  name='options[]' type="text" class="form-control" id="checkboxTitle"
                                                                placeholder="Başlık bilgisi giriniz..">
                                                    </div>
                                                    <div class="card border">
                                                        <label for="checkboxContent" class="form-label">Açılan Pencere İçeriği</label>

                                                        <textarea name="options[]" id="checkboxContent" cols="30" rows="10">İçeriği Giriniz...</textarea>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                            </div>

                    <!-- end card body -->
                </div>
                </form>

                <!-- end card -->
            </div>
            <!-- end col -->
        </div>
    @endsection
    @section('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
        <!-- App js -->
        <script >
            $(document).ready(function() {
                $('.js-example-basic-single').select2();
            });
        </script>

        <script>
            function typeCheck(){
                var selectedValue = document.getElementById('type').value;
                document.querySelectorAll('.optiondiv > input').forEach(function(inputField) {
                    inputField.value = '';
                });
                selectDivAction();

                if (selectedValue === 'select') {
                    parentDivShow('selectdiv');
                } if (selectedValue === 'checkbox') {
                    parentDivShow('checkboxdiv');
                }
            }

            function parentDivShow(divname){
                var optionDiv = document.getElementById(divname);
                optionDiv.classList.remove('d-none');
            }
            function selectDivAction(){
                document.querySelectorAll('#optiondiv > div').forEach(function(div) {
                    div.classList.add('d-none');
                });

            }
            document.getElementById('addOptionButton').addEventListener('click', function() {
                var candidateTableBody = document.getElementById('candidateTableBody');
                var rowCount = candidateTableBody.rows.length+1;

                // Yeni satır oluştur
                var newRow = document.createElement('tr');

                // Seçenek inputu için hücre oluştur
                var optionCell = document.createElement('td');
                var optionInput = document.createElement('input');
                optionInput.type = 'text';
                optionInput.name = 'option[' + rowCount + ']';
                optionInput.className = 'form-control';
                optionInput.placeholder = 'Seçenek Giriniz';
                optionCell.appendChild(optionInput);



                // Silme butonu için hücre oluştur
                var actionCell = document.createElement('td');
                var removeButton = document.createElement('button');
                removeButton.type = 'button';
                removeButton.className = 'btn btn-danger btn-sm';
                removeButton.textContent = 'Sil';
                removeButton.addEventListener('click', function() {
                    newRow.remove();
                });
                actionCell.appendChild(removeButton);

                // Hücreleri satıra ekle
                newRow.appendChild(optionCell);
                newRow.appendChild(actionCell);

                // Satırı tabloya ekle
                candidateTableBody.appendChild(newRow);
            });

            // Var olan silme butonları için olay dinleyici
            document.querySelectorAll('.remove-option').forEach(function(button) {
                button.addEventListener('click', function() {
                    this.closest('tr').remove();
                });
            });



        </script>

        <script src="{{ URL::asset('public/build/js/app.js') }}"></script>
@endsection
