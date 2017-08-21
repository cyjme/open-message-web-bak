import {loader} from 'zjs/loader';

loader.on('user.load', elem => {
    import(`./page/${elem.getAttribute('data-page')}.js`);
});
