$(document).ready(function () {
    function refreshView() {
        $.ajax({
            async: true,
            type: 'POST',
            url: "game/view",
            error: function (dataerror) {
                alert(dataerror);
            },
            success: function (data) {
                $('#game').html(data);
            }
        });
    }


    selected_case = undefined;
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

            $.ajax({
                async: true,
                //context: this,
                type: 'POST',
                url: 'game/action',
                data: data,
                error: function (dataerror) {
                    console.log(dataerror);
                },
                success: function (data) {
                    console.log(data);
                    console.log(data.status);
                    console.log(data.pos_move);
                    if (data.status === 'success') {
                        if (selected_case !== undefined) {
                            selected_case.removeClass('selected');
                        }

                        if (data.x_selected && data.y_selected) {
                            // nouvelle sélection
                            selected_case = selected_case_tmp;
                            selected_case.addClass('selected');

                            //affichage possibilites 1ere selection :
                            $('#game td').removeClass('possible');
                            $('#game td').removeClass('eat');
                            console.log('Possibilities : ');
                            for (i = 0; i < data.pos_move.length; i++) {
                                //$('td:td_' + data.pos_move['x'] + '_' + data.pos_move['y']).addClass('selected');
                                x1 = data.pos_move[i][0];
                                y1 = data.pos_move[i][1];
                                $('#td_' + x1 + '_' + y1).addClass('possible');
                                console.log($('#td_' + x1 + '_' + y1));
                            }
                            for (i = 0; i < data.pos_eat.length; i++) {
                                //$('td:td_' + data.pos_move['x'] + '_' + data.pos_move['y']).addClass('selected');
                                x1 = data.pos_eat[i][0];
                                y1 = data.pos_eat[i][1];
                                $('#td_' + x1 + '_' + y1).addClass('eat');
                                console.log($('#td_' + x1 + '_' + y1));
                            }
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
});