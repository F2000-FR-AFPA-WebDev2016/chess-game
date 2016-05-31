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
        // test 1 : Si c'est le premier click
        console.log(selected_case);
        if (selected_case === undefined) {
            // si oui , test 2 : y'atil une piece sur la case
            if ($(this).html().indexOf('img') >= 0) {
                selected_case_tmp = $(this);
                // si oui, selectionner la piece
                $.ajax({
                    async: true,
                    //context: this,
                    type: 'POST',
                    url: "game/action",
                    data: {
                        x1: $(this).data('x'),
                        y1: $(this).data('y')
                    },
                    error: function (dataerror) {
                        console.log(dataerror);
                    },
                    success: function (data) {
                        console.log(data);
                        console.log(data.status);
                        if (data.status === 'success') {
                            selected_case = selected_case_tmp;
                            selected_case.addClass('selected');
                        }
                    }
                });
            }
        } else {
            // deplacement ou nouvelle selection
            selected_case_tmp = $(this);
            $.ajax({
                async: true,
                //context: this,
                type: 'POST',
                url: "game/action",
                data: {
                    x1: selected_case.data('x'),
                    y1: selected_case.data('y'),
                    x2: $(this).data('x'),
                    y2: $(this).data('y')
                },
                error: function (dataerror) {
                    console.log(dataerror);
                },
                success: function (data) {
                    console.log(data);
                    console.log(data.status);
                    if (data.status === 'success') {
                        selected_case.removeClass('selected');

                        if (data.x_selected && data.y_selected) {
                            // nouvelle sélection
                            selected_case = selected_case_tmp;
                            selected_case.addClass('selected');
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