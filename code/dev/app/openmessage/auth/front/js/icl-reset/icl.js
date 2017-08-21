import {loader} from 'zjs/loader';

loader.on('reset.load', elem => {
    import(`./page/${elem.getAttribute('data-page')}.js`);
});
