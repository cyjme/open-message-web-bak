import {loader} from 'zjs/loader';

loader.on('reg.load', elem => {
    import(`./page/${elem.getAttribute('data-page')}.js`);
});
