import React from "react";

const ListGroup = ({
    items,
    textProperty,
    valueProperty,
    selectedItem,
    onItemSelect
}) => {
    return (
        <ul className="list-group mt-4 cursor">
            {items.map(item => (
                <li
                    onClick={() => onItemSelect(item)}
                    key={item[valueProperty]}
                    className={
                        item === selectedItem
                            ? "list-group-item active"
                            : "list-group-item"
                    }
                >
                    {item[textProperty]}
                </li>
            ))}
        </ul>
    );
};

ListGroup.defaultProps = {
    textProperty: "category_name",
    valueProperty: "id"
};

export default ListGroup;
