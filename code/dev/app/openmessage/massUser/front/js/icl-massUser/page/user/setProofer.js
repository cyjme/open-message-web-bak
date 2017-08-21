import { s } from 'zjs/s';
import { zview } from 'zjs/zview';
import { request } from 'zjs/http/request';
import { pageAttr } from 'zjs/html/page-attr';

s.elem('form').on('submit', () => {
    let form = s.elem('form');
    let licenceBefore = s.elem('[name="licenceBefore"]');
    let licence = s.elem('[name="licence"]');

    let uploadView = zview.view('.upload-img');

    licence.value = JSON.stringify(uploadView.getKeys());

    if (licence.value == '[]') {
        uploadView.clearImg();

        if (licenceBefore.value) {
            licence.value = licenceBefore.value;
        } else {
            alert("licence is required");
            return;
        }
    }

    let postData = new FormData(form);

    request.postJson(pageAttr('setProofer'), postData)
        .then(data => {
            if (data.status == 'ok') {
                window.location.replace('/proofer/submited-proofer');
            }
        });
});
