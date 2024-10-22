<!DOCTYPE html>
<!--[if IE 9]> <html class="ie9 no-js" lang="en"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html class="no-js" lang="en">
<!--<![endif]-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Larashop @yield("title")</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .grid-highlight {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: #5c6ac4;
            border: 1px solid #202e78;
            color: #fff;
        }
        hr {
            margin: 6rem 0;
        }
        hr+.display-3,
        hr+.display-2+.display-3 {
            margin-bottom: 2rem;
        }
        .polished-sidebar {
            background-color: #f8f9fa;
            height: 100vh;
            border-right: 1px solid #dee2e6;
        }
        .polished-sidebar .nav-link {
            color: #000;
        }
        .polished-sidebar .nav-link.active {
            background-color: #5c6ac4;
            color: #fff;
        }
    </style>
    <script type="text/javascript">
        document.documentElement.className = document.documentElement.className.replace('no-js', 'js');
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="{{ route('home') }}">Larashop</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="form-inline my-2 my-lg-0 w-50">
                <input class="form-control mr-sm-2 w-100" type="search" placeholder="Search" aria-label="Search">
            </form>
            <ul class="navbar-nav ml-auto">
                @if(Auth::user())
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Profile</a>
                        <a class="dropdown-item" href="#">Settings</a>
                        <div class="dropdown-divider"></div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="dropdown-item" type="submit">Sign Out</button>
                        </form>
                    </div>
                </li>
                @endif
            </ul>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar polished-sidebar collapse" id="sidebar-nav">
                <ul class="nav flex-column pt-4">
                    <li class="nav-item">
                        <a class="nav-link " href="/home">
                            <span class="oi oi-home"></span>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('users.index')}}">Manage Users <span class="oi oi-people"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('categories.index')}}">Manage Categories <span class="oi oi-people"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('books.index')}}">Manage Books <span class="oi oi-people"></span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('orders.index')}}">Manage Orders <span class="oi oi-people"></span></a>
                    </li>
       
                    <li class="nav-item">
                        <a class="nav-link" href="#">Settings</a>
                    </li>
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link btn btn-link" type="submit">Sign Out</button>
                        </form>
                    </li>
                </ul>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield("pageTitle")</h1>
                </div>

                @yield("content")
            </main>
        </div>
    </div>

    <!-- Bootstrap and jQuery JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
            @yield("footer-scripts")

</body>
</html>
