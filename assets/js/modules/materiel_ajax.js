/**

 */

export default class Materiel {

    constructor() {
        this.bindEvent();
    }

    bindEvent() {
        $.ajax({
            url: '/intranet/materiel/ajax/prereservation',
            method: 'POST',
            data: {
                commande: 'init',
                typeMat: 'Détendeur mer'
            },
            dataType: 'html',
            success: function (data) {
                $('#ajax_retour').html(data)
            }
        })
    }
/*
    xx() {
        const items = $('.ajax-select'); //
        items.each((k,i) => {
            i.addEventListener('click', e => {
                e.preventDefault();
                console.log('changed, id = ' + e.target.id + ', url = ' + e.target.form.action + ', value = ' + e.target.checked)
                $.ajax( {
                    method: 'post',
                    url: e.target.form.action,
                    dataType: 'json',
                    data: {
                        id: e.target.id,
                        value: e.target.checked
                    }
                })
                .done(function (json) {
                    var input = '#' + json.checkBox.id
                    var td = $(input).parents('.tbcolor')
                    var span = $(td).children('.nameCal')
                    var err  = $('.gonflage_error')
                    $(err).prop('hidden', true)
                    $(err).html('')
                    if (json.checkBox.value === 'true') {
                        $(input).prop('checked',true)
                        $(td).addClass('table-success')
                        $(span).html(json.checkBox.fullName)
                    } else {
                        $(input).prop('checked',false)
                        $(td).removeClass('table-success')
                        $(span).html('')
                    }
                    $('.gonflage_planning').html(json.planning)
                    $('.gonflage_synthese').html(json.synthese)
                })
                .fail(function (xhr,json) {
                    var err  = $('.gonflage_error')
                    err.prop('hidden', false)
                    err.html(xhr.responseJSON.error)
                })
            })
        });
    }*/
}
