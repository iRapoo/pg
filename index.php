<html lang="ru">
<head>
    <title>PG slots item calculator</title>

    <link rel="shortcut icon" href="favicon.png" type="image/x-icon">
</head>
<body>

<label>
    <input type="number" class="slot_all" placeholder="Всего слотов"/>
</label>
<label>
    <input type="number" class="slot_busy" placeholder="Занято слотов"/>
</label>

<span>Powered by Quenix Apps</span><br><br>

<div class="result" style="display: inline-block;"></div>&nbsp;&nbsp;&nbsp;
<button>{{spinBtnLabel}}</button>&nbsp;&nbsp;&nbsp;<span class="timeout"></span>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="libs/jquery.mfancytitle-0.4.1.min.js"></script>
<script src="calc.js"></script>

</body>
</html>