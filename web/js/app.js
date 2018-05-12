$(function() {
    if ($('#lottery_box').length) {
        Lottery.getLotteryBox();
    }
    if ($('#prizes').length) {
        Lottery.getPrizes();
    }

    $(document)
            .on('click', '.prizes_update', Lottery.getPrizes)
            .on('click', '#lottery_play', Lottery.play)
            .on('click', '#prize_accept', Lottery.acceptPrize)
            .on('click', '#prize_to_card', Lottery.paymentPrize)
            .on('click', '#prize_reject', Lottery.rejectPrize)
});

var Lottery = {
    prizesId: 0, // checking for update is needed
    prizesRefresh: 30000, // prizes refresh timeout in milliseconds

    getLotteryBox: function () {
        $.ajax({
            method:     'POST',
            url:        '/lottery/box',
            dataType:   'HTML'
        }).done(function(response) {
            $('#lottery_box').empty().append(response);
            console.log('Box updated');
        });
    },
    getPrizes: function (e, prizesId) {
        if (typeof prizesId === 'undefined') {
            prizesId = Math.random();
            Lottery.prizesId = prizesId;
        }
        if (prizesId !== Lottery.prizesId) {
            console.log('Prizes update rejected');
            return false;
        }

        $.ajax({
            method:     'POST',
            url:        '/lottery/prizes',
            dataType:   'HTML'
        }).done(function(response) {
            $('#prizes').empty().append(response);
            console.log('Prizes updated');
            var prizesId = Math.random();
            Lottery.prizesId = prizesId;
            setTimeout(function() {
                Lottery.getPrizes(null, prizesId);
            }, Lottery.prizesRefresh);
        });
    },
    getPoints: function() {
        $.ajax({
            method:     'POST',
            url:        '/index/points',
            dataType:   'HTML'
        }).done(function(response) {
            $('.user_points').empty().append(response);
            console.log('Points updated');
        });
    },
    play: function() {
        $('#lottery_box').empty().append('Processing...');
        $.ajax({
            method:     'POST',
            url:        '/lottery/play',
            dataType:   'HTML'
        }).done(function(response) {
            $('#lottery_box').empty().append(response);
            console.log('Winners updated');
            Lottery.getPrizes();
        });
    },
    acceptPrize: function() {
        $('#lottery_box').empty().append('Processing...');
        $.ajax({
            method:     'POST',
            url:        '/lottery/accept',
            dataType:   'HTML'
        }).done(function(response) {
            $('#lottery_box').empty().append(response);
            console.log('Prize accepted');
            Lottery.getPoints();
        });
    },
    rejectPrize: function() {
        $('#lottery_box').empty().append('Processing...');
        $.ajax({
            method:     'POST',
            url:        '/lottery/reject',
            dataType:   'HTML'
        }).done(function(response) {
            $('#lottery_box').empty().append(response);
            console.log('Prize rejected');
            Lottery.getPrizes();
        });
    },
    paymentPrize: function() {
        $('#lottery_box').empty().append('Processing...');
        $.ajax({
            method:     'POST',
            url:        '/lottery/payment',
            dataType:   'HTML'
        }).done(function(response) {
            $('#lottery_box').empty().append(response);
            console.log('Prize payed');
        });
    }
};