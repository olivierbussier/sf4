const routes = require('../../../public/js/fos_js_routes.json');
import Routing from '../../../public/bundles/fosjsrouting/js/router'
Routing.setRoutingData(routes);


export default function () {
    var form = $('#inscript').serializeArray();
    $.ajax({
        method: "POST",
        //url: "{{ url("ajax_calculate", {'licMode': inscrType}) }}",
        url: Routing.generate('ajax_calculate',{licMode: 'normal'}),
        data: form,
        success: function (ret, statut) {
            var tab = JSON.parse(ret)
            document.getElementById("pmain_detail").innerHTML = tab['css'] + tab['detail'];
            document.getElementById("pmain_total").innerHTML = tab['total'];
            document.getElementById("pmain_rfam").innerHTML = tab['msgFamille'];
        }
    })
}
