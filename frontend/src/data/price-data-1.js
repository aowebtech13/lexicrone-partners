import PriceList from "../svg/price-list"

import pric_img_1 from "../../public/assets/img/price/price-icon-1.png";
import pric_img_2 from "../../public/assets/img/price/price-icon-2.png";
import pric_img_3 from "../../public/assets/img/price/price-icon-3.png";


const price_data_home_one = [
    //  monthly price here 1 to 3
    {
        id: 1, 
        img: pric_img_1,
        title: "Leximan Team",
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
        title: "Mr Roy",
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
   
   
     
]
export default price_data_home_one