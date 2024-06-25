<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Settings">
    <meta name="generator" content="">
    <title>GTW Settings</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"
        integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA=="
        crossorigin="anonymous" />
    <link rel="stylesheet" id="css-main" href="{{ asset('asset/bootstrap/v4/css/bootstrap.min.css') }}">

    <meta name="theme-color" content="#7952b3">
    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }

        body {
            background: linear-gradient(to right, rgb(71, 118, 230), rgb(142, 84, 233));
        }

        .form-group {
            margin-bottom: 3px;
        }

    </style>

</head>

<body>
    <div class="container" style="margin-top:50px;">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        <form action="{{ route('settings.save') }}" method="post">
            @csrf

            <?php try {
            DB::connection()->getPdo();
            $dbConnect = '<h6 class="card-subtitle mb-2  text-success"><i class="fas fa-cog fa-spin"></i> Database
                connection successfully!!</h6>';
            } catch (\Exception $e) {
            $dbConnect = '<h6 class="card-subtitle mb-2 text-danger"><i class="fas fa-exclamation-triangle"></i>
                Database connection Fail</h6>';
            // die("Could not connect to the database. Please check your configuration. error:" . $e );
            } ?>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title"><i class="fas fa-database"></i> ติดต่อฐานข้อมูล</h5>
                            <?= $dbConnect ?>
    </div>
    <div class="card-body">
      
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-3 col-form-label">Hostname</label>
            <div class="col-9">
                <input type="text" value="{{ env('DB_HOST') }}" name="DB_HOST" class="form-control"  placeholder="เช่น 127.0.0.1" />
            </div>
        </div>
        
        <div class="form-group row">
            <label for="inputEmail" class="col-sm-3 col-form-label">Database</label>
            <div class="col-9">
                <input type="text" value="{{ env('DB_DATABASE') }}" name="DB_DATABASE" class="form-control" id="inputEmail" placeholder="ชื่อ database" >
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail" class="col-sm-3 col-form-label">User</label>
            <div class="col-9">
                <input type="text" value="{{ env('DB_USERNAME') }}" name="DB_USERNAME" class="form-control" id="inputEmail" placeholder="sa" >
            </div>
        </div>

        <div class="form-group row">
            <label for="inputEmail" class="col-sm-3 col-form-label">Port</label>
            <div class="col-9">
                <input type="text" value="{{ env('DB_PORT') }}" name="DB_PORT" class="form-control" id="inputEmail" placeholder="sa" >
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
            <div class="col-9">
                <input type="password" value="{{ env('DB_PASSWORD') }}"  name="DB_PASSWORD" class="form-control" id="inputPassword" placeholder="Password" >
            </div>
        </div>

        
    </div>
    <div class="card-footer text-muted">
        <button type="submit" class="btn btn-primary"><i class="fas fa-check"></i> บันทึก</button>

    </div>
</div>
            </div>
            <div class="col-6">

                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-server"></i> การเชื่อมต่อ</h5>
                    </div>
                    <div class="card-body">

                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Update API</label>
                    <div class="col-9">
                        <input type="text" value="{{ env('APP_API') }}" name="APP_API" class="form-control"  placeholder="เช่น 127.0.0.1" />
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-3 col-form-label">Datacenter</label>
                    <div class="col-9">
                        <input type="text" value="{{ env('APP_DATACENTER') }}" name="APP_DATACENTER" class="form-control"  placeholder="เช่น 127.0.0.1" />
                    </div>
                </div>

                                        
            </div>
            <div class="card-footer text-muted">
                <i class="fas fa-plug"></i> Online 
            </div>
        </div>

            </div>
        </div>

        </form>
        </div>
  

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="{{ asset('asset/bootstrap/v4/js/bootstrap.min.js') }}"></script>
      
  </body>
</html>
