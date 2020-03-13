<input type="number" class="slot_all" placeholder="Всего слотов"/>
<input type="number" class="slot_busy" placeholder="Занято слотов"/>

<span>Powered by Quenix Apps</span><br><br>

<div class="result"></div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>

    let HEAP1 = 0;
    let HEAP2 = 0;
    let CALC = 0;
    let resObject = {};

    $(function () {

        let SLOT_ALL = $('.slot_all');
        let SLOT_BUSY = $('.slot_busy');
        let RESULT = $('.result');

        SLOT_ALL.keyup(function () {
            HEAP1 = SLOT_ALL.val();
        });

        SLOT_BUSY.keyup(function () {
            HEAP2 = SLOT_BUSY.val();
            resObject = calcPG();
            if (resObject.status) {
                RESULT.html('Кол-во: ' + resObject.iter);
                RESULT.append(' / Время: ' + resObject.time);
            } else {
                RESULT.html(resObject.message);
            }
        });

    });

    function calcPG() {
        let diff = (HEAP1 - HEAP2);     // Разница слотов
        let middle = 3;                 // Среднее число выпаданий
        let kd = 5;                     // Время возобновления в минутах

        if (diff < 0) return {
            'status': false,
            'message': 'Слотов занято больше чем доступно!'
        };

        if (diff === 0) return {
            'status': false,
            'message': 'Вы набрали максимальное количество!'
        };

        return {
            'status': true,
            'iter': Math.round(diff / middle),
            'time': timeConvert(((diff / middle) * kd) * 60)
        };
    }

    function timeConvert(sec) {
        let h = sec / 3600 ^ 0;
        let m = (sec - h * 3600) / 60 ^ 0;
        return ((h < 10 ? "0" + h : h) + " ч. " + (m < 10 ? "0" + m : m) + " мин. ");
    }

</script>