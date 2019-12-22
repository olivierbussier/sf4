/**

 */
export default class Droits {

    /**
     * TODO a refaire completement
     */
    constructor() {
        this.bindEvents();
    }

    bindEvents() {
        const items = $('.ajax-select'); //
        items.each((k,i) => {
            i.addEventListener('change', e => {
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
                    var jid = '#' + json.id
                    if (json.newState === 'true') {
                        $(jid).prop('checked',true)
                        var par = $(jid).parent('td')
                        $(jid).parents('.tbcolor').addClass('table-success')
                    } else {
                        $(jid).prop('checked',false)
                        $(jid).parents('.tbcolor').removeClass('table-success')
                    }

                })
            })
        });
    }
}
