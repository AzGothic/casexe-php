$(function() {
    if ($('#lottery_box').length) {
        Lottery.getLotteryBox();
    }
    if ($('#prizes').length) {
        Lottery.getPrizes();
    }

    $(document)
        .on('click', '.item_sent', function (e) {
            e.preventDefault();
            var winnerId = $(this).data('winner');
            $(this).closest('td').empty().append('Processing...');
            return Admin.sentItem(winnerId);
        })
        .on('click', '.user_transfer', function (e) {
            e.preventDefault();
            var userId = $(this).data('user');
            $(this).closest('td').empty().append('Processing...');
            return Admin.userTransfer(userId);
        })
});

var Admin = {
    sentItem: function (winnerId) {
        $.ajax({
            method:     'POST',
            url:        '/admin/winners/sent',
            data:       {winnerId: winnerId},
            dataType:   'HTML'
        }).done(function() {
            location.reload(true);
        });
    },
    userTransfer: function (userId) {
        $.ajax({
            method:     'POST',
            url:        '/admin/winners/transfer',
            data:       {userId: userId},
            dataType:   'HTML'
        }).done(function() {
            location.reload(true);
        });
    }
};