<!DOCTYPE html>
<html>
<head>
    <title>Office</title>
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/luckysheet@latest/dist/plugins/css/pluginsCss.css' />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/luckysheet@latest/dist/plugins/plugins.css' />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/luckysheet@latest/dist/css/luckysheet.css' />
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/luckysheet@latest/dist/assets/iconfont/iconfont.css' />
    <script src="https://cdn.jsdelivr.net/npm/luckysheet@latest/dist/plugins/js/plugin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luckysheet@latest/dist/luckysheet.umd.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
</head>
<body>
<script>
function myFunction() {
    var excel = luckysheet.getAllSheets();
    //去除临时数据,减小体积
    for(var i in excel) excel[i].data = undefined
    $.post(
        "https://"+ location.host +"/set?id=" + <?php echo $id ?>,
        {hash:JSON.stringify(excel)},
        function(){
            $(luckysheet_info_detail_save).text("已保存")
        })
}
</script>
<div id="luckysheet" style="margin:0px;padding:0px;position:absolute;width:70%;height:100%;left: 0px;top: 0px;">
</div>
<script>
    $(function () {
        // var name = "";
        // while(name.length == 0){
        //     name = prompt("请输入昵称")
        // }

        var autoSave;
        //配置项
        var options = {
            lang: 'zh',
            container: 'luckysheet',
            allowUpdate: true,
            loadUrl:"https://"+ location.host +"/get?id=" + <?php echo $id ?>,
            hook:{
                updated:function(e){
                    //监听更新,并在3s后自动保存
                    if(autoSave) clearTimeout(autoSave)
                    $(luckysheet_info_detail_save).text("已修改")
                    autoSave = setTimeout(function(){
                        var excel = luckysheet.getAllSheets();
                        //去除临时数据,减小体积
                        for(var i in excel) excel[i].data = undefined
                        $.post(
                            "https://"+ location.host +"/set?id=<?php echo $id ?>",
                            {hash:JSON.stringify(excel)},
                            function(){
                                $(luckysheet_info_detail_save).text("已保存")
                            })
                    },3 * 1000)
                    return true;
                }
            },
            // updateUrl: "ws://" + location.hostname
        }

        console.log(JSON.stringify(options))
        luckysheet.create(options)
    })
</script>
<div id="cata" style="float:right;width:30%;">
<nav id="navbar-example3" class="navbar navbar-light bg-light flex-column align-items-stretch p-3">
  <a class="navbar-brand" href="#">OFFICE</a>
  <nav class="nav nav-pills flex-column">
    <a class="nav-link" href="#item-1">Item 1</a>
    <nav class="nav nav-pills flex-column">
      <a class="nav-link ms-3 my-1" href="?id=1">Item 1-1</a>
      <a class="nav-link ms-3 my-1" href="?id=2">Item 1-2</a>
    </nav>
  </nav>
</nav>

</div>
<button class="btn btn-primary" onclick="myFunction()">OK</button>
</div>
</body>
</html>