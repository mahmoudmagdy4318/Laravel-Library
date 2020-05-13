import ReactDOM from "react-dom";
import React, { Component } from "react";
import { getBooks } from "../services/bookService";
import ListGroup from "./listGroup";
import Pagination from "./pagination";
import SearchBox from "./searchBox";
import { paginate } from "../utils/paginate";
import _ from "lodash";


class BookList extends Component {
    state = {
        books: [],
        categories: [],
        selectedCategory: null,
        searchQuery: "",
        currentPage: 1,
        pageSize: 6
    };

    async componentDidMount() {
        const { data } = await getBooks();
        const books = Object.values(data.books);
        let categories = Object.values(data.categories);
        categories = [
            { id: "", category_name: "All Categories" },
            ...categories
        ];
        console.log(books, categories);
        this.setState({ books, categories });
    }

    handleCategorySelect = category => {
        console.log(category);
        this.setState({
            selectedCategory: category,
            searchQuery: "",
            currentPage: 1
        });
    };

    handleSearch = query => {
        this.setState({
            searchQuery: query,
            selectedCategory: null,
            currentPage: 1
        });
    };

    handlePageChange = page => {
        this.setState({ currentPage: page });
    };

    getPagedData = () => {
        const {
            pageSize,
            currentPage,
            selectedCategory,
            searchQuery,
            books: allBooks
        } = this.state;

        let filtered = allBooks;
        if (searchQuery) {
            filtered = allBooks.filter(b =>
                b.book_title.toLowerCase().startsWith(searchQuery.toLowerCase())
            );
        } else if (selectedCategory && selectedCategory.id)
            filtered = allBooks.filter(b => b.cat_id === selectedCategory.id);

        const books = paginate(filtered, currentPage, pageSize);
        return { totalCount: filtered.length, data: books };
    };

    render() {
        const { pageSize, currentPage, searchQuery } = this.state;
        const { totalCount, data: books } = this.getPagedData();
        console.log(this.state.books.length===0)

        if (this.state.books.length===0) return( <h3>no books in data base</h3>);
        return (
            <React.Fragment>
                <div class="container">
                    <div class="row">
                            <SearchBox value={searchQuery} onChange={this.handleSearch} />
                    </div>
                    <div class="row">
                        <div class="col-lg-3">
                            <ListGroup
                                items={this.state.categories}
                                selectedItem={this.state.selectedCategory}
                                onItemSelect={this.handleCategorySelect}
                            />
                        </div>
                        <div class="col-lg-9">
                            <div
                                id="carouselExampleIndicators"
                                class="carousel slide my-4"
                                data-ride="carousel"
                            >
                                <ol class="carousel-indicators">
                                    <li
                                        data-target="#carouselExampleIndicators"
                                        data-slide-to="0"
                                        class="active"
                                    ></li>
                                    <li
                                        data-target="#carouselExampleIndicators"
                                        data-slide-to="1"
                                    ></li>
                                    <li
                                        data-target="#carouselExampleIndicators"
                                        data-slide-to="2"
                                    ></li>
                                </ol>
                                <div class="carousel-inner" role="listbox">
                                    <div class="carousel-item active">
                                        <img
                                            class="d-block img-fluid"
                                            src="http://placehold.it/900x350"
                                            alt="First slide"
                                        />
                                    </div>
                                    <div class="carousel-item">
                                        <img
                                            class="d-block img-fluid"
                                            src="http://placehold.it/900x350"
                                            alt="Second slide"
                                        />
                                    </div>
                                    <div class="carousel-item">
                                        <img
                                            class="d-block img-fluid"
                                            src="http://placehold.it/900x350"
                                            alt="Third slide"
                                        />
                                    </div>
                                </div>
                                <a
                                    class="carousel-control-prev"
                                    href="#carouselExampleIndicators"
                                    role="button"
                                    data-slide="prev"
                                >
                                    <span
                                        class="carousel-control-prev-icon"
                                        aria-hidden="true"
                                    ></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a
                                    class="carousel-control-next"
                                    href="#carouselExampleIndicators"
                                    role="button"
                                    data-slide="next"
                                >
                                    <span
                                        class="carousel-control-next-icon"
                                        aria-hidden="true"
                                    ></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                            <div class="row">
                                {books.map((book, index) => (
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="card h-100">
                                            <a href="#">
                                                <img
                                                    class="card-img-top"
                                                    src="http://placehold.it/700x400"
                                                    alt=""
                                                />
                                            </a>
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    {book.book_title}
                                                </h4>
                                                <h5>$24.99</h5>
                                                <p class="card-text">
                                                    {book.book_description}
                                                </p>
                                            </div>
                                            <div class="card-footer">
                                                <small class="text-muted">
                                                    &#9733; &#9733; &#9733;
                                                    &#9733; &#9734;
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                ))}
                            </div>
                            <div class="row">
                                <div class="col-9">
                                    <Pagination
                                        itemsCount={totalCount}
                                        pageSize={pageSize}
                                        currentPage={currentPage}
                                        onPageChange={this.handlePageChange}
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </React.Fragment>
        );
    }
}
if (document.getElementById("app")) {
    ReactDOM.render(<BookList />, document.getElementById("app"));
}
