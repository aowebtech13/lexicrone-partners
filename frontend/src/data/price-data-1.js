import PriceList from "../svg/price-list"

import pric_img_1 from "../../public/assets/img/price/price-icon-1.png";
import pric_img_2 from "../../public/assets/img/price/price-icon-2.png";
import pric_img_3 from "../../public/assets/img/price/price-icon-3.png";


const price_data_home_one = [
    //  monthly price here 1 to 3
    {
        id: 1, 
        img: pric_img_1,
        title: "Starter Plan",
        desctiption: <>Begin your forex journey with stability</>,
        cls: "",
        pric: "500+",
        price_feature: [
            {
                list: "10% Weekly ROI",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Minimum: $500",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Maximum: $5,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "24/7 Expert Support",
                icon: <PriceList />,
                cls: ""
            }
        ],

    }, 
    {
        id: 2, 
        img: pric_img_2,
        title: "Professional",
        desctiption: <>Accelerate your wealth growth</>,
        cls: "active",
        pric: "5,000+",
        price_feature: [
            {
                list: "15% Weekly ROI",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Minimum: $5,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Maximum: $20,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Priority Support",
                icon: <PriceList />,
                cls: ""
            }
        ],

    }, 
    {
        id: 3, 
        img: pric_img_3,
        title: "Enterprise",
        desctiption: <>Institutional grade investing</>,
        cls: "",
        pric: "20,000+",
        price_feature: [
            {
                list: "20% Weekly ROI",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Minimum: $20,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Unlimited Max",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Personal Account Manager",
                icon: <PriceList />,
                cls: ""
            }
        ],

    },   
    
    
    //  yearly price here  4 to 6
    {
        id: 4, 
        img: pric_img_1,
        title: "Starter (Long-term)",
        desctiption: <>Extended growth for new investors</>,
        cls: "",
        pric: "4,500/yr",
        price_feature: [
            {
                list: "12% Weekly ROI",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Minimum: $500",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Maximum: $5,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "24/7 Support",
                icon: <PriceList />,
                cls: ""
            }
        ],

    }, 
    {
        id: 5, 
        img: pric_img_2,
        title: "Professional (Long-term)",
        desctiption: <>Maximizing portfolio performance</>,
        cls: "active",
        pric: "45,000/yr",
        price_feature: [
            {
                list: "18% Weekly ROI",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Minimum: $5,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Maximum: $20,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Priority Support",
                icon: <PriceList />,
                cls: ""
            }
        ],

    }, 
    {
        id: 6, 
        img: pric_img_3,
        title: "Enterprise (Long-term)",
        desctiption: <>The ultimate investment tier</>,
        cls: "",
        pric: "180,000/yr",
        price_feature: [
            {
                list: "25% Weekly ROI",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Minimum: $20,000",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "Unlimited Max",
                icon: <PriceList />,
                cls: ""
            },
            {
                list: "VIP Concierge Service",
                icon: <PriceList />,
                cls: ""
            }
        ],

    },  
]
export default price_data_home_one