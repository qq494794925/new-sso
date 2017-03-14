<!DOCTYPE html>
<html lang="zh-CN"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="description" content="ldap模拟登陆">
    <meta name="author" content="ryan">
    <link rel="icon" href="/favicon.ico">

    <title>LDAP登陆</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="/css/signin.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
<!--    <!--[if lt IE 9]><!--<script src="../../assets/js/ie8-responsive-file-warning.js"></script>-->
<!--    <script src="/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <!--<script src="//cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>-->
<!--      <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="post" action="/sso/ldap/dologin">

        <input type="hidden" id="app_id" name="app_id" value="">
        <input type="hidden" id="jumpto" name="jumpto" value="">

        <h2 class="form-signin-heading">请登录</h2>
        <label for="inputEmail" class="sr-only">用户名</label>
        <input name="uname" id="inputEmail" class="form-control" placeholder="用户名" required="" autofocus="" >
        <label for="inputPassword" class="sr-only">密码</label>
        <input name="upwd" id="inputPassword" class="form-control" placeholder="密码" required="" type="password">
<!--        <button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>-->


        <input type="submit" value="登陆">
      </form>

    </div> <!-- /container -->


    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<!--    <script src="/js/ie10-viewport-bug-workaround.js"></script>-->

  <!--添加jquery文件并以post方式向后台提交登陆-->
  

</body>
<script language="javascript">

    function getRequest() {
        var url = location.search; //获取url中"?"符后的字串
        var theRequest = new Object();
        if (url.indexOf("?") != -1) {
            var str = url.substr(1);
            strs = str.split("&");
            for(var i = 0; i < strs.length; i ++) {
                theRequest[strs[i].split("=")[0]]=unescape(strs[i].split("=")[1]);
            }
        }
        return theRequest;
    }

    window.onload=function(){
        var request = getRequest();
        var app_id  = request['app_id'];
        var jumpto  = request['jumpto'];

        document.getElementById('app_id').value = request['app_id'];
        document.getElementById('jumpto').value = request['jumpto'];

    }


</script>


</html>
