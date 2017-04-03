/**
 * Created by lenovo on 2017/3/8.
 */
$(document).ready(function() {
    var lastcol = $('.single').first().find('thead th').length-1
    console.log(lastcol)
    $('table').DataTable({
        "order": [[ lastcol, "desc" ]],
        "language": {
            "search": "搜索 :",
            "paginate": {
                "next": "下一页",
                "previous":"上一页"
            },
            "info":"显示第 _START_ 到 _END_ 条数据,共 _TOTAL_ 条",
            "lengthMenu":     "显示 _MENU_ 条数据",
        }
    });
} );