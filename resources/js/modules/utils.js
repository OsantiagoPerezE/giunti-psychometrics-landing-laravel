export const normalize = (value) =>
    String(value).toLowerCase().normalize("NFD").replace(/[̀-ͯ]/g, "");

export const scrollToCatalog = () =>
    document.getElementById("catalogo")?.scrollIntoView({ behavior: "smooth" });
