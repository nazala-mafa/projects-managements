if (window.location.pathname === "/projects") {
  import("./projects");
}

if (window.location.pathname.split("/")[3] === "tasks") {
  import("./tasks");
}
