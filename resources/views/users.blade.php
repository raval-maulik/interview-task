<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
</head>
<body>
    <div class="container">
        <table class="table" id="user_table">
            <thead>
                <th>Name</th>
                <th>Gender</th>
                <th>email</th>
                <th>Action</th>
            </thead>
            <tbody>

                <!-- @foreach($users as $key =>$value)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->gender }}</td>
                    <td>{{ $value->email }}</td>
                </tr>
                @endforeach -->
            </tbody>
        </table>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="  crossorigin="anonymous"></script>

<script type="text/javascript" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        // $("#user_table").DataTable();
        $('#user_table').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": "{{route('user_list')}}",
            "columns": [
                {"data": "name"},
                {"data": "gender"},
                {"data": "email"},
                {"data": "id",render:action_btn},

            ],
            // "sDom": '<"top"lf>t<"bottom"pi>',
            
            aoColumnDefs: [
                {
                    bSortable: false,
                    aTargets: [3]
                },
            ],
            "aaSorting": []
        });

        function action_btn(data, type, full, meta) {
            return  '<button type="button" class="btn btn-primary user_detail" data-id="'+full.id+'" data-toggle="modal" data-target="#myModal">'+'View</button>';
                    
        }

    });

    $(document).on("click",".user_detail",function() {
        var id = $(this).data("id");
        // alert(id);
        $("#modal_body").html("Loading..");
        $.ajax({
            url: "api/user_detail/"+id,
            success: function(result){
                var detail ="";
                $.each(result, function( index, value ) {
                    detail = detail+index + ": " + value+"<br>";
                    });
                $("#modal_body").html(detail);
            }
        });
    })
</script>
</html>


<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">User Detail</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body" id="modal_body">
            Loading..
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>