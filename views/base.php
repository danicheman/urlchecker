<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="Check URLs for tags and tag counts">
    <meta name="author" content="Nick Ostrowski">
    <title>URL Tag Inspector</title>
    <script type="text/javascript" src="js/jquery-1.12.0.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/highlight.pack.js"></script>
    <script type="text/javascript" src="js/urlchecker.js"></script>
    
    <link rel="stylesheet" type="text/css" href="css/ir-black.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/urlchecker.css">
        
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <a class="navbar-brand" href="#">URL Tag Inspector</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <form id="url-form" class="navbar-form navbar-right" method="post">
            <div class="form-group">
              <input type="text" name="url" pattern="^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$" class="form-control" required />
            </div>
            <button type="submit" rel="/urlcheck/" class="btn btn-success">Load URL</button>
          </form>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>
    <!-- floating div with tags and counts -->
    <div class="wrapper" >
        <div class="tag-scrollbox">
            <table class="table tags table-hover">
                <tr>
                    <th>Tags</th>
                    <th>Counts</th>
                </tr>
            </table>
        </div>
    </div>
    <!-- the loaded HTML source -->
    <div class="response">
        <div class="container-fluid">
        </div>
    </div>
</body>
</html>