$(document).ready(function () {
    selected_case = undefined;

    function refreshView() {
        url = START_URL + '/game/refresh';
        idGame = getGameId();
        if (idGame) {
            url += '/' + idGame;
        }

        $.ajax({
            async: true,
            type: 'POST',
            url: url,
            error: function (dataerror) {
                console.log(dataerror);
            },
            success: function (data) {
                $('#game').html(data);
            }
        });
    }

    function updateCases(data, css_class) {
        $('#game td').removeClass(css_class);
        for (i = 0; i < data.length; i++) {
            //$('td:td_' + data.pos_move['x'] + '_' + data.pos_move['y']).addClass('selected');
            x1 = data[i][0];
            y1 = data[i][1];
            $('#td_' + x1 + '_' + y1).addClass(css_class);
            console.log($('#td_' + x1 + '_' + y1));
        }
    }

    function getGameId() {
        return $('#board').data('id');
    }

    $(document).on('click', '#game td', function () {
        data = undefined;

        // test 1 : Si c'est le premier click
        if (selected_case === undefined) {
            // si oui , test 2 : y'a til une piece sur la case
            if ($(this).html().indexOf('img') >= 0) {
                data = {
                    x1: $(this).data('x'),
                    y1: $(this).data('y')
                };
            }
        } else {
            // second click : deplacement ou nouvelle selection
            data = {
                x1: selected_case.data('x'),
                y1: selected_case.data('y'),
                x2: $(this).data('x'),
                y2: $(this).data('y')
            };
        }

        if (data !== undefined) {
            selected_case_tmp = $(this);

            url = START_URL + '/game/action';
            idGame = getGameId();
            if (idGame) {
                url += '/' + idGame;
            }

            $.ajax({
                async: true,
                //context: this,
                type: 'POST',
                url: url,
                data: data,
                error: function (dataerror) {
                    console.log(dataerror);
                },
                success: function (data) {
                    console.log(data);
                    if (data.status === 0) {
                        if (selected_case !== undefined) {
                            selected_case.removeClass('selected');
                        }

                        if (data.x_selected && data.y_selected) {
                            // nouvelle sélection
                            selected_case = selected_case_tmp;
                            selected_case.addClass('selected');

                            if (data.pos_move) {
                                updateCases(data.pos_move, 'possible');
                            }
                            if (data.pos_eat) {
                                updateCases(data.pos_eat, 'eat');
                            }
                            updateCases([data.posKingCheck], 'danger');

                        } else {
                            // action effectuee
                            refreshView();
                            selected_case = undefined;
                        }
                    }
                }
            });
        }

        //$(this).css("background-color", "blue");
        console.log($(this).data('x') + ',' + $(this).data('y'));
    });

    $(document).on('change', '#form_difficulty', function () {
        var value = $('#form_difficulty').val();
        console.log(value);

        url = START_URL + '/game/options/difficulty';
        idGame = getGameId();
        if (idGame) {
            url += '/' + idGame;
        }

        $.ajax({
            async: true,
            type: 'POST',
            url: url,
            data: {
                'difficulty': value
            },
            error: function (dataerror) {
                console.log(dataerror);
            },
            success: function (data) {
                refreshView();
            }
        });


    });

    $(document).on('change', '#form_theme', function () {
        var value = $('#form_theme').val();
        console.log(value);

        $.ajax({
            async: true,
            type: 'POST',
            url: START_URL + '/options/theme',
            data: {
                'theme': value
            },
            error: function (dataerror) {
                console.log(dataerror);
            },
            success: function (data) {
                refreshView();
            }
        });
    });

    if (getGameId()) {
        setInterval(
                function () {
                    if ($('#board').data('refresh') === 1) {
                        refreshView();
                    }
                },
                2000);
    }
});