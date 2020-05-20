import ReactDOM from "react-dom";
import React, { Component } from "react";
import { getFavavouriteBooks } from "../services/bookService";
import { storeFavavouriteBook } from "../services/bookService";
import { deleteFavouriteBook } from "../services/bookService";
import { faHeart } from "@fortawesome/free-solid-svg-icons";
import { FontAwesomeIcon } from "@fortawesome/react-fontawesome";
import Button from "@material-ui/core/Button";

class FavouriteBook extends Component {
    state = {
        favs: []
    };
    async componentDidMount() {
        const { data } = await getFavavouriteBooks();
        this.setState({ favs: data }, () => {
            this.state.favs.forEach((book) => {
                this.setState(state => ({ [book.id]: !state[book.id] }));
            });
        });
    }
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
    render() {
        const { favs } = this.state;
        if (this.state.favs.length === 0)
            return <h3>you don't have any favourites</h3>;

        return (
            <React.Fragment>
                <div class="container">
                    <div class="row mt-3">
                        {favs.map((book, index) => (
                            <div class="col-lg-4 col-md-6 mb-4" key={index}>
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
                                        <h5>{book.price_per_day}$</h5>
                                        <p class="card-text">
                                            {book.book_description}
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
                                                this.toggleIcon(book.id, event)
                                            }
                                        />
                                    </div>

                                    <div class="card-footer">
                                        <Button
                                            variant="outlined"
                                            color="primary"
                                            id={book.id}
                                        >
                                            Lease
                                        </Button>
                                    </div>
                                </div>
                            </div>
                        ))}
                    </div>
                </div>
            </React.Fragment>
        );
    }
}
if (document.getElementById("fav")) {
    ReactDOM.render(<FavouriteBook />, document.getElementById("fav"));
}
