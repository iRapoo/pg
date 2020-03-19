<input type="number" class="slot_all" placeholder="Всего слотов"/>
<input type="number" class="slot_busy" placeholder="Занято слотов"/>

<span>Powered by Quenix Apps</span><br><br>

<div class="result" style="display: inline-block;"></div>&nbsp;&nbsp;&nbsp;
<button>Крутить</button>&nbsp;&nbsp;&nbsp;<span class="timeout"></span>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>

<script>

    const MID = 3;  // Среднее число выпаданий
    const KD = 5;   // Время возобновления в минутах

    let HEAP = JSON.parse(localStorage.getItem('savedHeap')) || {h1: 0, h2: 0};
    let CALC = 0;
    let resObject = {};

    let SLOT_ALL, SLOT_BUSY, RESULT, ADD_BTN, TIMEOUT;
    let timerId;

    $(function () {

        SLOT_ALL = $('.slot_all');
        SLOT_BUSY = $('.slot_busy');
        RESULT = $('.result');
        ADD_BTN = $('button');
        TIMEOUT = $('.timeout');

        if (HEAP.h1 > 0) SLOT_ALL.val(HEAP.h1);
        if (HEAP.h2 > 0) SLOT_BUSY.val(HEAP.h2); else ADD_BTN.hide();
        if (HEAP.h1 > 0 || HEAP.h2 > 0) render();

        SLOT_ALL.keyup(function () {
            HEAP.h1 = parseInt(SLOT_ALL.val()) || 0;
            render();
        });

        SLOT_BUSY.keyup(function () {
            HEAP.h2 = parseInt(SLOT_BUSY.val()) || 0;
            render();
            updateTimeCountDown();
        });

        ADD_BTN.click(function () {
            HEAP.h2 += MID;
            render();
            SLOT_BUSY.val(HEAP.h2);
            updateTimeCountDown();
        });

    });

    function calcPG() {
        let diff = (HEAP.h1 - HEAP.h2);

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
        resObject = calcPG();
        if (resObject.status) {
            RESULT.html('Кол-во: ' + resObject.iter);
            RESULT.append(' / Время: ' + resObject.time);
            ADD_BTN.show();
        } else {
            RESULT.html(resObject.message);
            ADD_BTN.hide();
        }
        localStorage.setItem('savedHeap', JSON.stringify(HEAP));
        timerId = setInterval(countDown);
    }

    function updateTimeCountDown() {
        localStorage.setItem('timePosition', Date.now().toString());
        clearInterval(timerId);
        timerId = setInterval(countDown);
    }

    function countDown() {
        let timePosition = parseInt(localStorage.getItem('timePosition'));
        let timePositionFuture = timePosition + ((1000 * 60) * KD);
        let timeNow = Date.now();
        let timeCalc = timePositionFuture - timeNow;

        let formatTime = getTime(timeCalc);
        if (timeCalc > 0) {
            TIMEOUT.html('<i>' + formatTime.mins + ' мин. ' + formatTime.secs + ' сек.</i>');
        } else {
            TIMEOUT.html('Жмакай давай!!!');
            if (timePosition > 0) {
                alert('Жмакай давай!!!');
                clearInterval(timerId);
                localStorage.removeItem('timePosition');
            }
        }
    }

    function timeConvert(sec) {
        let h = sec / 3600 ^ 0;
        let m = (sec - h * 3600) / 60 ^ 0;
        return ((h < 10 ? '0' + h : h) + ' ч. ' + (m < 10 ? '0' + m : m) + ' мин. ');
    }

    function getTime(millis) {
        return {
            hours: Math.floor(millis / 36e5),
            mins: Math.floor((millis % 36e5) / 6e4),
            secs: Math.floor((millis % 6e4) / 1000)
        };
    }

</script>