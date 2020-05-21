import ReactDOM from "react-dom";
import React, { Component } from "react";
import { getBooks } from "../services/bookService";
import { storeFavavouriteBook } from "../services/bookService";
import { deleteFavouriteBook } from "../services/bookService";
import { storeLeasedBook } from "../services/bookService";
import ListGroup from "./listGroup";
import Pagination from "./pagination";
import SearchBox from "./searchBox";
import { paginate } from "../utils/paginate";
import _ from "lodash";
import { faHeart } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import Button from "@material-ui/core/Button";
import TextField from "@material-ui/core/TextField";
import Dialog from "@material-ui/core/Dialog";
import DialogActions from "@material-ui/core/DialogActions";
import DialogContent from "@material-ui/core/DialogContent";
import DialogContentText from "@material-ui/core/DialogContentText";
import DialogTitle from "@material-ui/core/DialogTitle";
import { makeStyles } from "@material-ui/core/styles";
import Alert from "@material-ui/lab/Alert";

class BookList extends Component {
    state = {
        books: [],
        filteredBooks: [],
        categories: [],
        selectedCategory: null,
        searchQuery: "",
        currentPage: 1,
        orderByRate:false,
        orderBylatest: false,
        pageSize: 6,
        totalCount: 0,
        favourites: [],
        open: false,
        setOpen: false,
        total: 0,
        InputVal: null,
        bookName: "",
        bookPrice: 0,
        bookId: null,
        error: null
    };
    async componentDidMount() {
        const { data } = await getBooks();
        const books = Object.values(data.books);
        let categories = Object.values(data.categories);
        categories = [
            { id: "", category_name: "All Categories" },
            ...categories
        ];
        const favourites = Object.values(data.favouriteBooks);
        // console.log(books, categories);
        this.setState({ books, categories, favourites });
    }

    handleCategorySelect = category => {
        // console.log(category);
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
            books: allBooks,
            orderByRate,
            orderBylatest
        } = this.state;

        let filtered = allBooks;
        if (searchQuery) {
            filtered = allBooks.filter(b =>
                b.book_title.toLowerCase().startsWith(searchQuery.toLowerCase())
            );
        } else if (selectedCategory && selectedCategory.id) {
            filtered = allBooks.filter(b => b.cat_id === selectedCategory.id);
        }
        if (orderByRate) {
            filtered = allBooks.sort((a, b) => parseInt(b.rate) -  parseInt(a.rate));
        }
           if (orderBylatest) {
               filtered = allBooks.sort(
                   (a, b) => new Date(b.created_at) - new Date(a.created_at)
               );
           }
        const books = paginate(filtered, currentPage, pageSize);

        return { totalCount: filtered.length, data: books };
    };
    

    toggleIcon = (id, event) => {
        this.setState(
            state => ({ [id]: !state[id] }),
            () => {
                if (this.state[id] == true) {
                    storeFavavouriteBook(id).then(response => {
                        console.log(response);
                    });
                } else if (this.state[id] == false) {
                    deleteFavouriteBook(id).then(response => {
                        this.setState({ [id]: undefined });
                    });
                }
            }
        );
    };
    handleClickOpen = book => {
        this.setState({
            setOpen: true,
            open: true,
            bookName: book.book_title,
            bookPrice: book.price_per_day,
            bookId: book.id
        });
    };

    calcToatal = event => {
        let total = 0;
        const { bookPrice } = this.state;
        if (isNaN(event.target.value) || isNaN(bookPrice)) {
            total = 0;
            this.setState({ total: total });
        } else {
            total = parseInt(event.target.value) * parseInt(bookPrice);
            this.setState({ total: total, InputVal: event.target.value });
        }
    };
    handleClose = flag => {
        if (flag == 1) {
            this.setState({ setOpen: false, open: false });
        } else if (flag == 2) {
            const { total, InputVal, bookId } = this.state;
            storeLeasedBook(bookId, total, parseInt(InputVal)).then(
                response => {
                    // console.log(response)
                    this.setState({
                        setOpen: false,
                        open: false,
                        total: 0,
                        error: response.data
                    });
                }
            );
        }
        // if (flag == 1) {

        // } else if (flag == 2) {
        //     storeLeasedBook()
        //     this.setState({ setOpen: false, open: false });
        // }
    };

    render() {
        const { pageSize, currentPage, searchQuery, error, total } = this.state;
        const { totalCount, data: books } = this.getPagedData();
        // const classes = useStyles();

        if (this.state.books.length === 0)
            return <h3>no books in data base</h3>;
        return (
            <React.Fragment>
                <div class="container">
                    <div class="row">
                        <div class="col-md-6">
                            <SearchBox
                                value={searchQuery}
                                onChange={this.handleSearch}
                            />
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex">
                                <h4 class="mt-4 mr-2">oreder by</h4>
                                <button
                                    type="button"
                                    name="rateOrder"
                                    id="rate"
                                    className="btn btn-info mt-3"
                                    onClick={() => {
                                        this.setState({ orderByRate: true });
                                    }}

                                >
                                    rate
                                </button>
                                <button
                                    type="button"
                                    name="latestOrder"
                                    id="latest"
                                    className="btn btn-info ml-3  mt-3"
                                    onClick={() => {
                                        this.setState({ orderBylatest: true });
                                    }}
                                >
                                    latest
                                </button>
                            </div>
                        </div>
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
                            {error && (
                                <Alert
                                    severity="info"
                                    onClose={() => {
                                        this.setState({ error: null });
                                    }}
                                >
                                    {error}
                                </Alert>
                            )}
                            <div class="row">
                                {books.map((book, index) => (
                                    <div
                                        class="col-lg-4 col-md-6 mb-4"
                                        key={index}
                                    >
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
                                                <p class="card-text">
                                                    <a
                                                        href={"book/" + book.id}
                                                        target="_blanck"
                                                    >
                                                        book details
                                                    </a>
                                                </p>

                                                <FontAwesomeIcon
                                                    id={book.id}
                                                    icon={faHeart}
                                                    size="2x"
                                                    color={
                                                        this.state[book.id]
                                                            ? "red"
                                                            : "lightgray"
                                                    }
                                                    onClick={event =>
                                                        this.toggleIcon(
                                                            book.id,
                                                            event
                                                        )
                                                    }
                                                />
                                            </div>

                                            <div class="card-footer">
                                                {/* <small class="text-muted">
                                                    &#9733; &#9733; &#9733;
                                                    &#9733; &#9734; &#9829;
                                                </small> */}
                                                <Button
                                                    variant="outlined"
                                                    color="primary"
                                                    onClick={() =>
                                                        this.handleClickOpen(
                                                            book
                                                        )
                                                    }
                                                    id={book.id}
                                                >
                                                    Lease
                                                </Button>
                                            </div>
                                        </div>
                                    </div>
                                ))}

                                <Dialog
                                    open={this.state.open}
                                    onClose={() => this.handleClose(1)}
                                    aria-labelledby="form-dialog-title"
                                    fullWidth={true}
                                    maxWidth={"sm"}
                                >
                                    <DialogTitle id="form-dialog-title">
                                        Lease {this.state.bookName}
                                    </DialogTitle>
                                    <DialogContent>
                                        <DialogContentText></DialogContentText>
                                        <TextField
                                            autoFocus
                                            margin="dense"
                                            id="name"
                                            label="number of days"
                                            type="number"
                                            fullWidth
                                            onChange={event =>
                                                this.calcToatal(event)
                                            }
                                        />
                                        <p class="mt-2">
                                            You should pay
                                            {total}
                                        </p>
                                    </DialogContent>
                                    <DialogActions>
                                        <Button
                                            onClick={() => this.handleClose(1)}
                                            color="primary"
                                        >
                                            Cancel
                                        </Button>
                                        <Button
                                            onClick={() => this.handleClose(2)}
                                            color="primary"
                                        >
                                            Lease
                                        </Button>
                                    </DialogActions>
                                </Dialog>
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
