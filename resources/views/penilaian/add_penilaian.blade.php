@extends('layouts.master')

@section('title','Penilaian Mahasiswa')
@section('css')
  <!-- Datatables -->
    <link href="{{ URL::asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
    
    <link href="{{ URL::asset('vendors/alertify/css/alertify.min.css')}}" rel="stylesheet">
 
    <link href="{{ URL::asset('vendors/alertify/css/default.min.css')}}" rel="stylesheet">
@endsection
@section('sidebar')
@parent
@endsection
@section('content')

<div class="x_panel">
  <div class="x_title">
      <h2>Penilaian Mahasiswa</h2>
                    
      <div class="clearfix">
        <a href="{{url('/home/showkelasdosen')}}" class="btn btn-success pull-right"><i class="fa fa-list"></i> Tampilkan</a>
      </div>
  </div>
  <div class="x_content">
          
  <!--table-->
  {!! Form::open(array('url' => '/home/addkelasdosen', 'id'=>'form-kelasdosen')) !!}
    <table id="datatable-kelasdosen" class="table table-striped table-bordered">
      <thead>
        <tr>
        <th colspan="8">
           <div class="form-horizontal">
            
              <div class="form-group">
                <!-- {!! Form::label('kelas','Kelas',array('class' => 'col-sm-4 control-label')) !!} -->
                    <div class="col-sm-4">
                      {!! Form::select('kelas', $arrkelas, '0',array('class' => 'form-control', 'style' => 'width:130px;')) !!}
                    </div>
              </div>

              <div class="form-group">
                <!-- {!! Form::label('semester','Semester',array('class' => 'col-sm-4 control-label')) !!} -->
                    <div class="col-sm-4">
                      {!! Form::select('semester', $arrsemester, '0',array('class' => 'form-control', 'style' => 'width:130px;')) !!}

                    </div>
              </div>

              <div class="form-group">
               <!--  {!! Form::label('matkul','Mata Kuliah',array('class' => 'col-sm-4 control-label')) !!} -->
                    <div class="col-sm-4">
                    {!! Form::select('matkul', $arrmatkul, '0',array('class' => 'form-control', 'style' => 'width:200px;')) !!}
                    </div>
              </div>

            </div>
          </th>
        </tr>
        <tr>
          <th width="3%">No</th>
          <th>Nim</th>
          <th>Nama</th>
          <th>Absensi</th>
          <th>Seminar</th>
          <th>Tugas</th>
          <th>MID SM</th>
          <th>Semester</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="8"><button id="btn-submit" type="button" class="btn btn-success pull-left"><i class="fa fa-send"></i> Tambah</button> </th>          
        </tr> 
      </tfoot>
    </table>
    {!! Form::close() !!}
<!--endtable-->
  </div>
</div>

@endsection
@section('scripts')
<!-- Datatables -->

    <script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    
    <script src="{{ URL::asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{ URL::asset('vendors/alertify/js/alertify.min.js')}}"></script>

    



    <script type='text/javascript'>
    
    var gentable=null;
    $(document).ready(function(){

     

      var idkelas;
      var sem;
      var matkul;

      gentable = $('#datatable-kelasdosen').DataTable({
              processing  : true,
              searching   : false,
              bInfo       : false,
              bPaginate   : false,
              ajax        : '',
              fnDrawCallback: function ( oSettings ) {

                if ( oSettings.bSorted || oSettings.bFiltered )
                {
                    for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
                    {
                        $('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
                    }
                }
              },
              aoColumns: [
                  {data: null,    name: 'no'},
                  {data: 'nim',   name: 'nim'},
                  {data: 'nama',  name: 'nama'},
                  {data: null,         name: 'keterangan',
                    orderable : false,
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input type="text" name="absensi[]" id="absensi" class="form-control" size="4">';
                        }
                        return data;
                    },
                    className: "text-center",
                  },
                  {data: null,         name: 'keterangan',
                    orderable : false,
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input type="text" name="seminar[]" id="seminar" class="form-control" size="4"> <input type="hidden" name="nim[]" id="nim" value="'+data.nim+'">';
                        }
                        return data;
                    },
                    className: "text-center",
                  },
                  {data: null,         name: 'keterangan',
                    orderable : false,
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input type="text" name="tugas[]" id="tugas" class="form-control" size="4">';
                        }
                        return data;
                    },
                    className: "text-center",
                  },
                  {data: null,         name: 'keterangan',
                    orderable : false,
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input type="text" name="midsm[]" id="midsm" class="form-control" size="4">';
                        }
                        return data;
                    },
                    className: "text-center",
                  },
                  {data: null,         name: 'keterangan',
                    orderable : false,
                    render: function ( data, type, row ) {
                        if ( type === 'display' ) {
                            return '<input type="text" name="nsemester[]" id="nsemester" class="form-control" size="4">';
                        }
                        return data;
                    },
                    className: "text-center",
                  },
              ],
              aoColumnDefs: [
              //{ "visible": false, "aTargets": 1 },
              {"bSortable" : false, "aTargets": 0 },
              { aTargets  : [ -1 ] }

              ],
              
              aaSorting: [[ 1, 'asc' ]]

          });

        var sbody = $('#datatable-kelasdosen thead');
        sbody.on('change','.form-control',function(){

              idkelas = $('#kelas').val();
              sem     = $('#semester').val();
              matkul  = $('#matkul').val();
              
              url = '{{"getdatamhs"}}/'+idkelas+'/'+sem+'/'+matkul;
              gentable.ajax.url(url).load(); 

          });

        var sdatabody = $('#datatable-kelasdosen tfoot');
        sdatabody.on('click','#btn-submit',function(){
              
              var absensi;
              absensi = $('input[name="absensi[]"]').map(function() {
                return $(this).val();
              }).get();
              
              var seminar;
              seminar = $('input[name="seminar[]"]').map(function() {
                return $(this).val();
              }).get();

              var tugas;
              tugas = $('input[name="tugas[]"]').map(function() {
                return $(this).val();
              }).get();

              var midsm;
              midsm = $('input[name="midsm[]"]').map(function() {
                return $(this).val();
              }).get();

              var nsemester;
              nsemester = $('input[name="nsemester[]"]').map(function() {
                return $(this).val();
              }).get();

              var nim;
              nim = $('input[name="nim[]"]').map(function() {
                return $(this).val();
              }).get();

              $.ajax({
                type: 'POST',
                url: '{{"/home/addpenilaian"}}',
                data: {'nim':nim, 'matkul':matkul, 'absensi':absensi, 'seminar':seminar, 'tugas':tugas, 'midsm':midsm, 'nsemester':nsemester, 'idkelas':idkelas, 'sem':sem,  '_token' : $('input[name="_token"]').val()},
                dataType: 'json',
                success: function (data) {
                  
                    var returndata=data.return;
                    if(returndata==1){
                      alertify.success('Data Berhasil Disimpan');
                    }else{
                      alertify.alert("Error ","Data Input Tidak Valid ");
                    }
                    return false;
                  },
                  error: function (xhr,textStatus,errormessage) {
                    alertify.alert("Kesalahan! ","Error !!"+xhr.status+" "+textStatus+" "+"Tidak dapat mengirim data!");
                  },
                  complete: function () {
                    alert(url);
                    url = '{{"getdatamhs"}}/'+idkelas+'/'+sem+'/'+matkul;
                    gentable.ajax.url(url).load(); 
                  }
                });

          });



    });

    

   </script>
@endsection