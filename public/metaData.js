// AutoPartsStore JSON-LD
const autoPartsStoreData = {
    "@context": "https://schema.org",
    "@type": "AutoPartsStore",
    name: "Currus Connect",
    url: "https://currus-connect.com",
    logo: "https://currus-connect.com/img/logos/white-logo-final-EN.png",
    image: "https://currus-connect.com/img/logos/white-logo-final-EN.png",
    description:
        "Currus Connect is your trusted source for motor vehicle parts and accessories, offering over 30 years of experience with used spare parts.",
    address: {
        "@type": "PostalAddress",
        streetAddress: "Rentemestervej 67",
        addressLocality: "København",
        postalCode: "2400",
        addressCountry: "DK",
    },
    contactPoint: [
        {
            "@type": "ContactPoint",
            telephone: "",
            email: "support@currus-connect.com",
            contactType: "Customer Support",
            availableLanguage: [
                "English",
                "Danish",
                "German",
                "French",
                "Swedish",
                "Italian",
                "Polish",
            ],
        },
    ],
};

// BreadcrumbList JSON-LD
const breadcrumbListData = {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    itemListElement: [
        {
            "@type": "ListItem",
            position: 1,
            name: "Currus Connect - Your trusted source for vehicle parts and accesories.",
            item: "https://currus-connect.com",
        },
        {
            "@type": "ListItem",
            position: 2,
            name: "Browse - our catalogue of spare parts by type",
            item: "https://currus-connect.com/car-parts/search/by-name?search=",
        },
        {
            "@type": "ListItem",
            position: 3,
            name: "About Us - Who are we, and why are we doing this?",
            item: "https://currus-connect.com/about-us",
        },
        {
            "@type": "ListItem",
            position: 5,
            name: "FAQ - frequently asked question",
            item: "https://currus-connect.com/faq",
        },
        {
            "@type": "ListItem",
            position: 6,
            name: "Contact Us - got a question for us?",
            item: "https://currus-connect.com/contact",
        },
    ],
};

// Function to inject JSON-LD into the <head>
function injectJSONLD(data) {
    const script = document.createElement("script");
    script.type = "application/ld+json";
    script.text = JSON.stringify(data);
    document.head.appendChild(script);
}

// Inject both JSON-LD scripts
injectJSONLD(autoPartsStoreData);
injectJSONLD(breadcrumbListData);
