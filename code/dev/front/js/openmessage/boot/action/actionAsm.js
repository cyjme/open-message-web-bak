import {s} from 'zjs/s';

s('.check-action-asm').forEach((asmElem) => {
    asmElem.on('change', () => {
        s('.action-group.' + asmElem.getAttribute('data-set') + ' .list input').forEach((el) => {
            el.checked = asmElem.checked;
        });
    });
});
