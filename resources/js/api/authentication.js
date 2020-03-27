import axios from 'axios';

export default {
    authentication(data) {
        return axios.post('/api/v1/authentication', data);
    }
}
