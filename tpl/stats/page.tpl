<!DOCTYPE html>
<html lang="ru">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <title>{title}</title>
  <link rel="stylesheet" href="http://ais.snochuvsu.ru/plugins/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" href="http://ais.snochuvsu.ru/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <link rel="stylesheet" href="http://ais.snochuvsu.ru/dist/css/adminlte.min.css">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
  
<body class="hold-transition skin-blue layout-top-nav" data-version="12" data-role="{role}">
  <div class="wrapper">
  	<nav class="navbar navbar-expand-sm navbar-dark navbar-gray-dark">
      <a class="navbar-brand" href="#">АИС 2.0</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarsExample03">
        <ul class="navbar-nav mr-auto" id="menu">
        	 
          <!--<li class="nav-item active">-->
          <!--  <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>-->
          <!--</li>-->
        </ul>
      </div>
    </nav>
    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">{title}</h1>
            </div>
          </div>
        </div>
      </div>
      <div class="content">
        <div class="container-fluid">
        	{content}
        </div>
      </div>
    </div>

        <footer class="main-footer">
          <div class="float-right d-none d-sm-inline">
            Будущее за наукой!
          </div>
          <strong>Copyright &copy; 2016 <a href="https://daniilak.ru">Даниил Агниашвили</a>.</strong> All rights
          reserved.
        </footer>
      </div>
	<div class="modal fade" id="appendEvent" tabindex="-1" role="dialog" aria-labelledby="appendEventLabel" >
	    <div class="modal-dialog" role="document">
	        <div class="modal-content" >
	        	<form  class="formaddModal" data-toggle="validator" role="form" method="post" onSubmit="appendEvent(); return false;">
		            <div class="modal-header">
		                <h4 class="modal-title" id="appendEventLabel">Добавление мероприятия</h4>
		            </div>
		            <div class="modal-body">
						<div class="form-group">
							<label class="control-label">Название мероприятие:</label>
							<input type="text" class="form-control boxed" required="" name="add-event-name" id="add-event-name">
						</div>
					<div class="form-group">
						<label class="control-label">Конференция:</label>
						<select class="form-control boxed" name="add-event-conf-id" id="add-event-conf-id" required="">
						</select>
					</div>
					<div class="form-group">
						<label class="control-label">Тип:</label>
						<select class="form-control boxed" name="add-event-type" id="add-event-type" required="">
						</select>
					</div>
					<div class="form-group">
						<label class="control-label">Факультет:</label>
						<select class="form-control boxed" name="add-event-fac"  id="add-event-fac" required="">
						</select>
					</div>
					<div class="form-group">
						<label class="control-label">Дата и время проведения:</label>
						<input type="datetime-local" class="form-control boxed" name="add-event-date" id="add-event-date" required="">
					</div>
					<div class="form-group">
						<label class="control-label">Придумайте пароль для секции:</label>
						<input type="text" class="form-control boxed" name="add-event-pass" id="add-event-pass" required="">
					</div>
					<div class="form-group">
						<label class="control-label">Место проведения:</label>
						<input type="text" class="form-control boxed" name="add-event-location" id="add-event-location" required="">
						<p class="help-block">Например, Г-316</p>
					</div>
					
				
	                <div class="modal-footer">
	                    <button type="submit" class="btn btn-success"><i class="fa fa-paper-plane" id="spinner"></i>  Добавить</button>
	                    <button type="button" class="btn btn-default" data-dismiss="modal"> Отмена</button>
	                </div>
	            </div>
		        </form>
		    </div>
		</div>
	</div>

	<script src="http://ais.snochuvsu.ru/dist/js/root.js"></script>
    <script src="https://www.cssscript.com/demo/multi-select-autocomplete-selectpure/bundle.min.js"></script>

      <script src="http://ais.snochuvsu.ru/plugins/jquery/jquery.min.js"></script>
      <script src="http://ais.snochuvsu.ru/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="http://ajax.aspnetcdn.com/ajax/jquery.templates/beta1/jquery.tmpl.min.js"></script>
</body>

</html>