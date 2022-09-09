@extends('layouts.admin')
<x-admin.header />
<div class="container-fluid page-body-wrapper">
<x-admin.sidebar />
<div class="main-panel">
    <div class="content-wrapper">
        <div class="page-header">
            <h3 class="page-title"> Contact </h3>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a  href="{{ url('admin/deshboard')}}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <div class="float-right action-buttons ">
                            <button type="button" onclick="ExportToExcel('xlsx')" class="btn btn-sm m-b-15 ml-2 btn-primary" ><i class="mdi mdi-download"></i> Export</button>
                        </div>
                        <div class="row table-filters">
                            <div class="col-sm-12 col-md-4">
                                <div class="sort-options">
                                    <label>
                                        <button class="custom-select custom-select-sm form-control form-control-sm" onclick="sortTable(0)">Sort</button>
                                    </label>
                                    <label>
                                        <input  type="search Keyword"  id="searchInput" onkeyup="myFunction()" name="search" class="form-control form-control-sm" placeholder="Search" />
                                        </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="myTable"  class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Subject</th>
                                        <th>Create</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($contacts as $contact)
                                    <tr>
                                        <td>{{$contact['name']}}</td>
                                        <td>{{$contact['email']}}</td>
                                        <td>{{$contact['subject']}}</td>
                                        <td>{{$contact['created_at']}}</td>
                                        <td>
                                            <button  onclick="myfunction(`{{$contact['message']}}`)"  class="badge badge-success">View</button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="myModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="modalmessage" style="text-align: justify;padding: 20px;color: #000;font-size: 14px;"></p>

    </div>
</div>

<script>

function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('myTable');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }

    const myfunction = (message) =>{
        var modal = document.getElementById("myModal");
        document.getElementById("modalmessage").innerHTML = message;

        modal.style.display = "block";
        
        var btn = document.getElementById("myBtn");
        
        var span = document.getElementsByClassName("close")[0];
                
        span.onclick = function() {
        modal.style.display = "none";
        }

        window.onclick = function(event) {
        if (event.target == modal) {
        modal.style.display = "none";
        }
        }
    }

  function sortTable(n) {
  var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
  table = document.getElementById("myTable");
  switching = true;
  dir = "asc"; 

  while (switching) {
    switching = false;
    rows = table.rows;
    for (i = 1; i < (rows.length - 1); i++) {
      shouldSwitch = false;
      x = rows[i].getElementsByTagName("TD")[n];
      y = rows[i + 1].getElementsByTagName("TD")[n];

      if (dir == "asc") {
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          shouldSwitch= true;
          break;
        }
      } else if (dir == "desc") {
        if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
          shouldSwitch = true;
          break;
        }
      }
    }
    if (shouldSwitch) {
    
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switching = true;
      switchcount ++;      
    } else {
      if (switchcount == 0 && dir == "asc") {
        dir = "desc";
        switching = true;
      }
    }
  }
}

function myFunction() {
  var input, filter, table, tr, td, cell, i, j;
  filter = document.getElementById("searchInput").value.toLowerCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 1; i < tr.length; i++) {
    tr[i].style.display = "none";
    const tdArray = tr[i].getElementsByTagName("td");
    for (var j = 0; j < tdArray.length; j++) {
      const cellValue = tdArray[j];
      if (cellValue && cellValue.innerHTML.toLowerCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
        break;
      }
    }
  }
}

</script>



