import { Passkeys } from '@laravel/passkeys';

window.registerPasskey = async function (name) {
    return await Passkeys.register({ name });
};