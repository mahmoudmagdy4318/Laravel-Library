import http from './httpService';

const apiEndpoint="/books"

export async function getBooks() {
    return await http.get(apiEndpoint);
}
