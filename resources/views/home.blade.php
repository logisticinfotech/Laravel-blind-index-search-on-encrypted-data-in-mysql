<html>
<head>
	<link rel="stylesheet" type="text/css" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/dataTables/modern/datatables.min.css') }}">
</head>
<body>
	<section id="configuration">
		<div class="row">
			<div class="col-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-md-6">
								<h4 class="card-title">User List</h4>
							</div>
							<div class="col-md-6">
								<input type="text" class="form-control col-md-4" name="card_number" id="card_number" placeholder="For ex. 123-45-6789" />
							</div>
						</div>
						<a class="heading-elements-toggle"><i class="la la-ellipsis-v font-medium-3"></i></a>
						<div class="heading-elements">
							<ul class="list-inline mb-0">
								<li><a data-action="collapse"><i class="ft-minus"></i></a></li>
								<li><a data-action="expand"><i class="ft-maximize"></i></a></li>
								<li><a data-action="close"><i class="ft-x"></i></a></li>
							</ul>
						</div>
					</div>
					<div class="card-content collapse show">
						<div class="card-body card-dashboard">
							<table id="datatable" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>#</th>
										<th>Name</th>
										<th>Email</th>
										<th>Created At</th>
									</tr>
								</thead>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</body>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>

<script src="{{ asset('plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/dataTables/Responsive-2.2.1/js/dataTables.responsive.min.js') }}"></script>

<script>
$(document).ready(function() {
	var typingTimer;
	var doneTypingInterval = 700;
	var $input = $('#card_number');

	$input.on('keyup', function () {
		clearTimeout(typingTimer);
		typingTimer = setTimeout(doneTyping, doneTypingInterval);
	});

	$input.on('keydown', function () {
		clearTimeout(typingTimer);
	});

	function doneTyping () {
		oTable.draw();
	}

	// $('#card_number').on('keyup', function(e) {
	// 	oTable.draw();
    //     e.preventDefault();
    // });

    var oTable = $('#datatable').DataTable({
            "dom": '<"row" <"col-sm-4"l> <"col-sm-4"r> <"col-sm-4"f>> <"row"  <"col-sm-12"t>> <"row" <"col-sm-5"i> <"col-sm-7"p>>',
            processing: true,
            serverSide: true,
            responsive: true,
            pagingType: "full_numbers",
            "ajax": {
                "url": "{!! 'users/datatable' !!}",
				data: function(d) {
                    d.card_number = $('#card_number').val();
                },
            },
            columns: [
                { data: 'id', name: 'id', searchable: false, orderable:false,
                    width: 20, },
                { data: 'name', name: 'name'},
                { data: 'email', name: 'email'},
                { data: 'added_date', name: 'added_date'},
            ]
    });
});
</script>
</html>
