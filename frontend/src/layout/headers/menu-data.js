const menu_data = [
  {
    id: 1,
    mega_menu: false,
    has_dropdown: false,
    title: "Home",
    link: "/",
    active: "active",
  
  },

{
  id: 2,
  mega_menu: false,
  has_dropdown: false,
  title: "Copy trading",
  link: "/integrations",
  active: "",

},
  
  {
    id: 3,
    mega_menu: false,
    has_dropdown: true,
    title: "Projects",
    link: "/project",
    active: "",
    sub_menus: [
      { link: "/project", title: "Project" },
      { link: "/home-2", title: "Project Details" }, 
    ],
  },

 
  
  {
    id: 5,
    mega_menu: false,
    has_dropdown: false,
    title: "Contact",
    link: "/contact",
    active: "",
  },
  

];
export default menu_data;
