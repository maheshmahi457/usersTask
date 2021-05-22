<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Home</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/jquery.simple-popup.css" type="text/css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
</head>
<style>
    body {
        font-family: 'Roboto';
        line-height: 1.58;
        background-color: lightgrey;
    }

    .container {
        margin: 70px auto;
    }

    #popup1 {
        display: none;
    }

    table td,
    th {
        border: 1px solid black;
        text-align: center;
        padding: 1%
    }

    th {
        font-size: 20px;
        background-color: lightblue;
    }

    td {
        background-color: lightcyan;
    }

    table {
        width: 100%
    }

    #addNew {
        float: right;
        margin-bottom: 5%;
    }
</style>

<body>
    <div class="container">
        <script src="http://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="js/jquery.simple-popup.min.js"></script>
        <script>
            $(document).ready(function() {
                $("a.demo-2").simplePopup({
                    type: "html",
                    htmlSelector: "#popup1"
                });
            });
        </script>
        <div>
            <h2>User Records</h2>
            <a id="addNew" class="demo-2 btn btn-primary">Add New</a>
        </div>
        <div id="popup1">
            <h2>Add New User</h2>
            <form method="POST" enctype="multipart/form-data" action="./addUser">
                @csrf
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" />
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
                <div class="form-group">
                    <label for="fullName">Full Name</label>
                    <input type="text" class="form-control" placeholder="Full Name" name="fullName" />
                </div>

                <div class="form-group">
                    <label for="Joining Date">Date of Joining</label>
                    <input type="date" name="joiningDate">
                </div>
                <div class="form-group">
                    <label for="Leaving Date">Date of Leaving</label>
                    <input type="date" name="leavingDate">
                    <label>Still working</label>
                    <input type="checkbox" name="isWorking" value="true">
                </div>
                <div class="form-group">
                    <label>Upload Image</label>
                    <input type="file" name="fileName">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
        <table style="border: 1px sold black;border-collapse:collapse">
            <thead>
                <tr>
                    <th>Avatar</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Experience</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usersList as $user)
                <tr>
                    <td>
                        <img src="storage\app\public\images\Q1MQCmzF1Daa59VfCNJ1DZr8lRxiuCmCxdFvaYBd.png" width="auto">
                    </td>
                    <td>{{$user->full_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>
                        <?php
                        $dateDiff = $user->leaving_date ? date_diff(date_create($user->leaving_date), date_create($user->joining_date)) : date_diff(date_create(now()), date_create($user->joining_date));
                        echo $dateDiff->y . ' Years ' . $dateDiff->m . ' months ' . $dateDiff->d . ' days';
                        ?>
                    </td>
                    <td><a href="deleteUser/{{$user->id}}">Remove</a> </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('failure'))
        <div class="alert alert-danger">
            {{ session('failure') }}
        </div>
        @endif
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
</body>

</html>