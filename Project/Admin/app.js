const express = require("express");
const path = require("path");
const mysql = require("mysql2");
const adminRoute = require("./routes/admin.js");

require("dotenv").config();

const app = express();
const port = process.env.SERV_PORT;

app.use(express.static(__dirname + "/public/css"));
app.use(express.static(__dirname + "/public/images"));
app.use(express.urlencoded({ extended: false }));
app.set("view-engine", "ejs");
app.set("views", __dirname + "\\view");
// -------------------------------------------------------//
app.use(adminRoute);

app.all("*", (req, res) => {
  res.render("404.ejs", { eHeading: "OOPS", eCode: "404", eText: "Page not found.", eDesc: `The page you're for looking does not exist` });
});

// app.get("/login", userView.login);
// app.post("/login", userController.login);

const server = app.listen(port, () => {
  console.log("Server is listening on port ", port);
});
