import http from './httpService';

const apiEndpoint="/books"
const favouriteBookApi ="/favouritebooks"
const leasedBookApi ="/leasedBooks";

export async function getBooks() {
    return await http.get(apiEndpoint);
}
export function storeFavavouriteBook(bookId){
    return http.post(favouriteBookApi, { bookId: bookId });
}
export function  deleteFavouriteBook(bookId) {
    return http.delete(favouriteBookApi+'/'+bookId);    
}
export function storeLeasedBook(bookId,payed,days) {
    return http.post(leasedBookApi, { bookId: bookId ,payed:payed,days:days});
}
