import {loader} from 'zjs/loader';

loader.on('startup.load', elem => {
    import(`./page/${elem.getAttribute('data-page')}.js`);
});
