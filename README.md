# sas
成绩分析系统(score analysis system)
1.	通过初步分析课题，此成绩分析系统运行步骤大致为
导入成绩单（文件暂定为excel表格）->程序进行分析->生成表格以及图表->在页面展示->导出分析的结果(也暂定为excel)。
2.	程序运行环境为基于linux 或 windows 的web 服务器(apache或nginx)环境。涉及php,html,js,css 等web开发技术，以及可能会使用到的mysql数据库技术。
3.	技术点分析：
成绩导入导出均使用php 的扩展类库 PHPEXCEL，此类库功能强大可以自定义样式丰富的excel表格包括对数据生成图形报表。
要想使用必须保证以下php环境:
(1)	PHP 5.2.0以上版本
(2)	启用php_zip 扩展 (如果您需要PHPExcel处理.xlsx .ods或.gnumeric文件)
(3)	启用php_xml 扩展
(4)	启用php_gd2扩展(需要精确的列宽自动计算,生成图表)

数据导入后首先对数据缓存，这里先把数据序列化缓存到本地文件里面，方便后面导出分析结果。（也可以使用数据库或者redis等进行缓存）

利用phpexcel进行分析成绩单数据，之后利用js 库 chart.js 或者php类库jpgraph 将数据报表展示在浏览器上。(这两个库均为图表绘制库)

最后导出分析结果使用phpexcel 进行导出。(结果包含图形报表)。
