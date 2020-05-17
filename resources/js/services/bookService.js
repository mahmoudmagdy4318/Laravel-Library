import http from './httpService';

const apiEndpoint="/books"
const favouriteBookApi ="/favouritebooks"

export async function getBooks() {
    return await http.get(apiEndpoint);
}
export function storeFavavouriteBook(bookId){
    return http.post(favouriteBookApi, { bookId: bookId });
}
export function  deleteFavouriteBook(bookId) {
    return http.delete(favouriteBookApi+'/'+bookId);
    
}
