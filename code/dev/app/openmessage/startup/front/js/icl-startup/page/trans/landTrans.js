import {zview} from 'zjs/zview';

import {TransItemView} from 'openmessage-startup/trans/view/TransItemView.js';
import {UpdateTransForm} from 'openmessage-startup/trans/form/UpdateTransForm.js';
import {DeleteTransForm} from 'openmessage-startup/trans/form/DeleteTransForm.js';


zview({
    '.trans-item': TransItemView,
    '.update-trans-form': UpdateTransForm,
    '.delete-trans-form': DeleteTransForm
});
