<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Bootstrap CSS -->
      <link
         href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css"
         rel="stylesheet"
         integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1"
         crossorigin="anonymous"
      />
        <title>@yield('title') - Kippa</title>

       {{-- Laravel Mix - CSS File --}}
       {{-- <link rel="stylesheet" href="{{ mix('css/driver.css') }}"> --}}

    </head>
    <body>
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        {{-- <script src="{{ mix('js/driver.js') }}"></script> --}}
         <!-- Option 1: Bootstrap Bundle with Popper -->
      <script
         src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"
         integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW"
         crossorigin="anonymous"
      ></script>
    </body>
</html>
