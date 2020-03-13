<input type="number" class="slot_all" placeholder="Всего слотов"/>
<input type="number" class="slot_busy" placeholder="Занято слотов"/>

<span>Powered by Quenix Apps</span><br><br>

<div class="result" style="display: inline-block;"></div>&nbsp;&nbsp;&nbsp;<button>Крутить</button>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>

    const MID = 3;  // Среднее число выпаданий
    const KD = 5;   // Время возобновления в минутах

    let HEAP1 = 0;
    let HEAP2 = 0;
    let CALC = 0;
    let resObject = {};

    let SLOT_ALL, SLOT_BUSY, RESULT, ADD_BTN;

    $(function () {

        SLOT_ALL = $('.slot_all');
        SLOT_BUSY = $('.slot_busy');
        RESULT = $('.result');
        ADD_BTN = $('button');

        ADD_BTN.hide();

        SLOT_ALL.keyup(function () {
            HEAP1 = parseInt(SLOT_ALL.val());
        });

        SLOT_BUSY.keyup(function () {
            HEAP2 = parseInt(SLOT_BUSY.val());
            resObject = calcPG();
            render();
        });

        ADD_BTN.click(function () {
            HEAP2 += MID;
            resObject = calcPG();
            render();
            SLOT_BUSY.val(HEAP2);
        });

    });

    function calcPG() {
        let diff = (HEAP1 - HEAP2);

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
            'iter': Math.round(diff / MID),
            'time': timeConvert(((diff / MID) * KD) * 60)
        };
    }

    function render() {
        if (resObject.status) {
            RESULT.html('Кол-во: ' + resObject.iter);
            RESULT.append(' / Время: ' + resObject.time);
            ADD_BTN.show();
        } else {
            RESULT.html(resObject.message);
            ADD_BTN.hide();
        }
    }

    function timeConvert(sec) {
        let h = sec / 3600 ^ 0;
        let m = (sec - h * 3600) / 60 ^ 0;
        return ((h < 10 ? "0" + h : h) + " ч. " + (m < 10 ? "0" + m : m) + " мин. ");
    }

</script>