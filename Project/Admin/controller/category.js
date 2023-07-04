const categoryModel = require("../model/category.js").Category;

const unkownError = (res) => {
    res.render("404.ejs", { eCode: 503, eHeading: "OOPS", eText: "Service Unavailable", eDesc: "Try again later." });
};

const notFound = (res) => {
    res.render("404.ejs", { eCode: 404, eHeading: "OOPS", eText: "Not Found!", eDesc: "(^_^)" });
};

const requestHandler = async(req, res) => {
    if (req == 0) {
        return await getRecordsCount(res);
    } else if (req == 1) {
        return await getAll();
    } else if (req.body.status == -1) {
        deleteRecord(req, res);
    } else if (req.body.status == 0) {
        updateRecords(req, res);
    } else {
        displayRecords(req, res);
    }
};

const displayRecords = async(req, res) => {
    const searchVal = req.query.searchVal == undefined ? "" : req.query.searchVal;
    const limit = req.query.limit == undefined ? 10 : parseInt(req.query.limit) < 0 ? 1 : parseInt(req.query.limit);

    const queryCount = await categoryModel.getSearchCount(searchVal).catch((rejected) => {
        unkownError(res);
    });

    const allCategories = await categoryModel.getAll().catch((reject) => {
        unkownError(res);
    });

    let page = parseInt(req.query.page);
    if (page <= 0 || isNaN(page) || page > queryCount) {
        page = 1;
    }

    const offset = (page - 1) * limit;
    await categoryModel
        .searchRecords(searchVal, limit, offset)
        .catch((rejected) => {
            unkownError(res);
        })
        .then((resolved) => {
            let pages = Math.ceil(queryCount / limit);
            pages = req.query.limit != undefined ? 1 : pages;
            if (page > pages) {
                res.render("category.ejs", { categories: {}, searchVal: "", allCategories: {}, pagination: false, currentPage: 1, pageStart: 1, pageEnd: 0, maxPage: 1 }); //defaults
            } else {
                const pagination = pages > limit ? true : false;
                const pageStart = pagination ? offset * limit + 1 : 1;
                let pageEnd = pagination ? offset * limit + limit : pages;
                res.render("category.ejs", { categories: resolved, searchVal: searchVal, allCategories: allCategories, pagination: pagination, currentPage: page, pageStart: pageStart, pageEnd: pageEnd, maxPage: pages });
            }
        });
};

const deleteRecord = async(req, res) => {
    const id = parseInt(req.body.index);
    const response = await categoryModel.deleteRecord(id).catch((rejected) => {
        unkownError(res);
    });
    if (response.affectedRows == 1) {
        res.send(true);
    }
};

const updateRecords = async(req, res) => {
    const id = parseInt(req.body.index);
    const name = req.body.categoryName;
    let parentID = parseInt(req.body.categoryParent);

    if (isNaN(parentID)) {
        parentID = null;
    }

    await categoryModel
        .updateRecord(id, name, parentID)
        .catch((rejected) => {
            unkownError(res);
        })
        .then((resolved) => {
            if (resolved.affectedRows == 1) {
                res.send(true);
            }
        });
};

const getRecordsCount = async(res) => {
    const count = categoryModel.getSearchCount("").catch((rejected) => {
        unkownError(res);
    });

    return count;
};

const getAll = async(res) => {
    const response = categoryModel.getAll().catch((rejected) => {
        unkownError(res);
    });

    return response;
};

module.exports = { requestHandler };