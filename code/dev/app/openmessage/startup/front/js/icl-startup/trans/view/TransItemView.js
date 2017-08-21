import {View} from 'zjs/base/View.js';
import {Dto} from 'zjs/base/Dto.js';
import {pageAttr} from 'zjs/html/page-attr';
import {request} from 'zjs/http/request';

class TransItemView extends View {
    startup() {
        this.valElem = this.ctn.elem('.trans-val');
        this.key = this.ctn.getAttribute('data-key');
        this.localeKey = this.ctn.getAttribute('data-locale-key');

        this.dto = new Dto();

        this.updateForm = this.view('.update-trans-form');
        this.deleteForm = this.view('.delete-trans-form');

        this.dto.bind(this);
        this.dto.bind(this.updateForm);
        this.dto.bind(this.deleteForm);

        this.reg();
    }

    fetchTrans() {
        return request.postJson(
            pageAttr('apiFetchTrans'),
            {localeKey: this.localeKey, key: this.key}
        );
    }

    reg() {
        this
            .on('update', () => {
                this.fetchTrans().then(data => {
                    this.dto.load(data);
                    this.updateForm.show();
                });
            })
            .on('delete', () => {
                this.fetchTrans().then(data => {
                    this.dto.load(data);
                    this.deleteForm.show();
                });
            });

        this.updateForm
            .on('hide', () => this.updateForm.hide())
            .on('submit', (elem, e) => {
                e.stop();
                e.cancel();
                request.postJson(pageAttr('apiUpdateTrans'), new FormData(elem))
                    .then(data => {
                        if (data) {
                            this.dto.load(data);
                            this.updateForm.hide();
                        }
                    });
            });

        this.deleteForm
            .on('hide', () => this.deleteForm.hide())
            .on('submit', (elem, e) => {
                e.stop();
                e.cancel();
                request.postJson(pageAttr('apiDeleteTrans'), new FormData(elem))
                    .then(data => {
                        if (data) {
                            this.remove();
                        }
                    });
            });
    }
}

export {TransItemView};
