// Fenix Scripts 
let fenix_current_date = new Date();
fenix_current_date =  fenix_current_date.getTime();
let randomnumber = Math.floor(Math.random() * 99999);
let fenixsessionid = btoa(fenix_current_date+"-"+window.location.hostname+"-"+randomnumber);
if( localStorage.getItem("fenixSSID") == "" ){
  localStorage.setItem("fenixSSID", fenixsessionid);
}

// Fenix Commerce Globals. 
let fenixcommerceGlobal = {
  trucksvg : '<svg id="feinxtrucksvg" width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M22.4394 5.69627C22.2092 5.20095 21.8533 4.78434 21.4122 4.49369C20.971 4.20304 20.4623 4.05 19.9437 4.05193H15.9807V0.872088C15.9807 0.801317 15.9676 0.731238 15.9422 0.665856C15.9168 0.600474 15.8795 0.541068 15.8326 0.491031C15.7856 0.440994 15.7299 0.401307 15.6685 0.374235C15.6072 0.347163 15.5414 0.333238 15.475 0.333253H3.16636C3.09988 0.333091 3.03402 0.346908 2.97255 0.373914C2.91109 0.40092 2.85522 0.440585 2.80816 0.490637C2.76109 0.540689 2.72375 0.600144 2.69828 0.6656C2.6728 0.731055 2.65969 0.801225 2.65969 0.87209C2.65969 0.942955 2.6728 1.01312 2.69828 1.07858C2.72375 1.14404 2.76109 1.20349 2.80816 1.25354C2.85522 1.30359 2.91109 1.34326 2.97255 1.37027C3.03402 1.39727 3.09988 1.41109 3.16636 1.41093H14.9694V14.3095H9.77285C9.65579 13.6676 9.33291 13.0892 8.85957 12.6733C8.38623 12.2574 7.79191 12.0299 7.17849 12.0299C6.56506 12.0299 5.97074 12.2574 5.4974 12.6733C5.02406 13.0892 4.70119 13.6676 4.58412 14.3095H2.90029C2.83381 14.3093 2.76795 14.3231 2.70648 14.3501C2.64502 14.3772 2.58915 14.4168 2.54209 14.4669C2.49502 14.5169 2.45768 14.5764 2.43221 14.6418C2.40673 14.7073 2.39362 14.7775 2.39362 14.8483C2.39362 14.9192 2.40673 14.9894 2.43221 15.0548C2.45768 15.1203 2.49502 15.1797 2.54209 15.2298C2.58915 15.2798 2.64502 15.3195 2.70648 15.3465C2.76795 15.3735 2.83381 15.3873 2.90029 15.3872H4.58412C4.70122 16.029 5.0241 16.6074 5.49744 17.0233C5.97077 17.4392 6.56508 17.6666 7.17849 17.6666C7.79189 17.6666 8.3862 17.4392 8.85953 17.0233C9.33287 16.6074 9.65576 16.029 9.77285 15.3872H16.6218C16.7389 16.029 17.0618 16.6074 17.5351 17.0233C18.0085 17.4392 18.6028 17.6666 19.2162 17.6666C19.8296 17.6666 20.4239 17.4392 20.8972 17.0233C21.3705 16.6074 21.6934 16.029 21.8105 15.3872H23.4944C23.5608 15.3872 23.6265 15.3732 23.6878 15.3462C23.7492 15.3191 23.8049 15.2794 23.8519 15.2294C23.8988 15.1793 23.9361 15.1199 23.9615 15.0546C23.9869 14.9892 24 14.9191 24 14.8483V9.14962C23.9999 9.06596 23.9816 8.98346 23.9465 8.90866L22.4394 5.69627ZM7.17849 16.5889C6.8555 16.589 6.53975 16.4869 6.27118 16.2957C6.0026 16.1044 5.79326 15.8326 5.66964 15.5145C5.54601 15.1964 5.51365 14.8464 5.57664 14.5088C5.63963 14.1711 5.79515 13.8609 6.02353 13.6175C6.2519 13.374 6.54288 13.2082 6.85966 13.141C7.17645 13.0739 7.5048 13.1083 7.8032 13.2401C8.10161 13.3718 8.35666 13.595 8.53609 13.8812C8.71553 14.1675 8.8113 14.504 8.81129 14.8483C8.8108 15.3098 8.63862 15.7522 8.33252 16.0785C8.02642 16.4048 7.61139 16.5884 7.17849 16.5889ZM19.9437 5.12962C20.2744 5.12839 20.5988 5.22596 20.8801 5.41128C21.1614 5.59659 21.3883 5.86223 21.5352 6.17805L22.9887 9.27688V9.64732H15.9807V5.12962H19.9437ZM19.2162 16.5889C18.8932 16.589 18.5774 16.4869 18.3089 16.2957C18.0403 16.1044 17.8309 15.8326 17.7073 15.5145C17.5837 15.1964 17.5513 14.8464 17.6143 14.5088C17.6773 14.1711 17.8328 13.8609 18.0612 13.6175C18.2896 13.374 18.5806 13.2082 18.8973 13.141C19.2141 13.0739 19.5425 13.1083 19.8409 13.2401C20.1393 13.3718 20.3943 13.595 20.5738 13.8812C20.7532 14.1675 20.849 14.504 20.849 14.8483C20.8485 15.3098 20.6763 15.7522 20.3702 16.0785C20.0641 16.4048 19.6491 16.5884 19.2162 16.5889ZM21.8105 14.3095C21.6935 13.6676 21.3706 13.0892 20.8973 12.6733C20.4239 12.2574 19.8296 12.0299 19.2162 12.0299C18.6027 12.0299 18.0084 12.2574 17.5351 12.6733C17.0617 13.0892 16.7389 13.6676 16.6218 14.3095H15.9807V10.725H22.9887V14.3095H21.8105ZM1.92902 4.44411H9.16389C9.23037 4.44395 9.29623 4.45777 9.3577 4.48477C9.41916 4.51178 9.47503 4.55144 9.52209 4.6015C9.56916 4.65155 9.6065 4.711 9.63197 4.77646C9.65745 4.84191 9.67056 4.91208 9.67056 4.98295C9.67056 5.05382 9.65745 5.12398 9.63197 5.18944C9.6065 5.2549 9.56916 5.31435 9.52209 5.3644C9.47503 5.41445 9.41916 5.45412 9.3577 5.48113C9.29623 5.50813 9.23037 5.52195 9.16389 5.52179H1.92902C1.86254 5.52195 1.79668 5.50813 1.73521 5.48113C1.67375 5.45412 1.61788 5.41445 1.57082 5.3644C1.52376 5.31435 1.48642 5.2549 1.46094 5.18944C1.43546 5.12398 1.42235 5.05382 1.42235 4.98295C1.42235 4.91208 1.43546 4.84191 1.46094 4.77646C1.48642 4.711 1.52376 4.65155 1.57082 4.6015C1.61788 4.55144 1.67375 4.51178 1.73521 4.48477C1.79668 4.45777 1.86254 4.44395 1.92902 4.44411ZM0 8.79289C2.80023e-06 8.72212 0.0130845 8.65204 0.0384979 8.58666C0.0639113 8.52127 0.101159 8.46187 0.148113 8.41183C0.195067 8.3618 0.250808 8.32211 0.312153 8.29504C0.373498 8.26797 0.439246 8.25404 0.50564 8.25406H6.76925C6.83573 8.25389 6.90159 8.26771 6.96305 8.29472C7.02452 8.32172 7.08038 8.36139 7.12745 8.41144C7.17451 8.46149 7.21185 8.52095 7.23733 8.5864C7.2628 8.65186 7.27592 8.72203 7.27592 8.79289C7.27592 8.86376 7.2628 8.93393 7.23733 8.99938C7.21185 9.06484 7.17451 9.12429 7.12745 9.17435C7.08038 9.2244 7.02452 9.26406 6.96305 9.29107C6.90159 9.31807 6.83573 9.33189 6.76925 9.33173H0.50564C0.439245 9.33175 0.373497 9.31782 0.312151 9.29075C0.250806 9.26367 0.195064 9.22399 0.14811 9.17395C0.101156 9.12391 0.0639085 9.0645 0.0384955 8.99912C0.0130826 8.93374 1.74955e-06 8.86366 0 8.79289Z" fill="black"></path></svg>',
  fenixformonchange : ".bc-form.bc-product-form",
  zipcode : localStorage.getItem('fenix_zipcode') || '10001',
  variations : jQuery("[data-js=product-variants-object]").attr("data-variants") || "{}",
  apiurl : "https://delest-api.bcapp.fenixcommerce.com/fenixdelest/api",
  tenantId :  localStorage.getItem('fenix-tenantId') || "6aa69d290f784247bf3dc41d6710d174",
  storeinfo : localStorage.getItem('fenix-storeinfo') || "",
  ajaxrequestcalled : null,
  pageType : jQuery("#fenixpdptype").val() || "",
  pdpsku :   "{}",
  cartsku : jQuery("#fenixskucart").val() || "{}"
}

if( jQuery("[data-js=product-variants-object]").length > 0  ){
  fenixcommerceGlobal.pdpsku = JSON.parse( jQuery("[data-js=product-variants-object]").attr("data-variants") )[0].sku;
}


// Show zipcode inputs.
function _fenixshowzipcode() {
    jQuery("#fenix-zip").show();
}


// Show popup for view all shipping options.
function _fenixshowviewallDisplay(hideshow) {
    if (hideshow == "hide") {
        jQuery(".fenix-provided-options.popup").hide();
    } else {
        jQuery(".fenix-provided-options.popup").show();
    }
}

// Construct html view all shipping options. 
function _fenixsetviewalloptions(zipcode, data, pageType) {
    let moreshippingoptions = "";

    jQuery.each(data, function(index, value) {
        moreshippingoptions += `<tr>
                            <td>${value.shippingMethodDesc}</td>
                            <td>${value.guaranteedDeliveryDate}</td>
                          </tr>`
    });


    let viewalltemplate = `<a href="javascript:void(0);" id="view-all-shipping" onclick="_fenixshowviewallDisplay('show')">View All Shipping Options</a>
                       <div class="fenix-provided-options popup" style="display: none;">
                          <div class="popuptext">
                             <h2 class="shipping-options-title">
                                <div>SHIPPING OPTIONS </div>
                                <div class="text-right fenixviewallclose" onclick="_fenixshowviewallDisplay('hide')" >x</div>
                             </h2>
                             <div class="fenix-logo" style="display:block !important;">
                                Powered by 
                                <svg viewBox="0 0 222 48" xmlns="http://www.w3.org/2000/svg" style="width:100px">
                                   <path d="m38.961 33.26h2.5213v-8.4419h6.0623v-2.153h-6.0623v-5.9206h6.2039l0.7366-2.153h-9.4618v18.668z" fill="#9D9D9D"></path>
                                   <path d="m61.823 27.113v-0.6232c0-4.2776-2.0113-6.9688-5.524-6.9688-3.4278 0-5.6657 2.8612-5.6657 6.9405 0 3.8243 2.0396 7.0821 6.4872 7.0821 1.5297 0 3.1445-0.4249 4.3909-1.2181l-0.7648-1.7281c-0.9349 0.5099-2.0397 0.9065-3.3428 0.9065-2.6346 0-4.1926-1.8696-4.221-4.3909h8.6402zm-8.6402-1.8697c0.0284-2.0396 1.1898-3.7393 3.1162-3.7393 2.0113 0 2.9178 1.8696 2.9461 3.7393h-6.0623z" fill="#9D9D9D"></path>
                                   <path d="m64.674 33.26h2.4929v-9.7167c1.1898-1.0198 2.4929-1.813 3.8527-1.813 1.8413 0 2.2946 1.4731 2.2946 3.3711v8.1586h2.4929v-8.9801c0-3.5128-1.9547-4.7592-4.0793-4.7592-1.6997 0-3.2011 0.7932-4.6459 1.983l-0.3116-1.6431h-2.0963v13.399z" fill="#9D9D9D"></path>
                                   <path d="m79.508 33.26h2.4929v-13.399h-2.4929v13.399zm1.2465-16.147c0.9348 0 1.643-0.7082 1.643-1.6147s-0.6799-1.5864-1.643-1.5864c-0.9349 0-1.5864 0.7082-1.5864 1.5864 0 0.9065 0.6515 1.6147 1.5864 1.6147z" fill="#9D9D9D"></path>
                                   <path d="m84.253 33.26h2.7195l3.5411-5.0141 3.5127 5.0141h2.6912l-4.7592-6.7705 4.7876-6.6289h-2.6629l-3.4844 4.9292-3.3995-4.9292h-2.7478l4.7025 6.6855-4.9008 6.7139z" fill="#9D9D9D"></path>
                                   <path d="m112.51 30.172c-1.303 0.7082-2.72 1.2181-4.476 1.2181-4.108 0-6.686-3.0028-6.686-7.3654 0-4.0793 2.607-7.4504 6.856-7.4504 1.87 0 3.314 0.4816 4.646 1.1898v-2.3513c-0.992-0.5382-2.691-0.9915-4.703-0.9915-5.665 0-9.4615 4.3059-9.4615 9.7167 0 5.4674 3.3425 9.4051 9.0655 9.4051 1.756 0 3.597-0.3683 5.467-1.3598l-0.708-2.0113z" fill="#D0D0D0"></path>
                                   <path d="m121.32 33.543c3.852 0 6.373-3.0595 6.373-6.9972 0-3.966-2.549-7.0255-6.345-7.0255-3.853 0-6.374 3.0595-6.374 7.0255 0 3.9377 2.521 6.9972 6.346 6.9972zm0-2.068c-2.352 0-3.768-2.068-3.768-4.9292 0-2.8895 1.416-4.9575 3.796-4.9575 2.351 0 3.768 2.068 3.768 4.9575 0 2.8612-1.417 4.9292-3.796 4.9292z" fill="#D0D0D0"></path>
                                   <path d="m130.54 33.26h2.493v-9.745c1.162-0.9915 2.465-1.7847 3.796-1.7847 1.842 0 2.238 1.4447 2.238 3.3144v8.2153h2.493v-9.0368c0-0.2266-0.028-0.4816-0.028-0.7082 1.161-0.9915 2.464-1.7847 3.796-1.7847 1.841 0 2.238 1.4447 2.238 3.2861v8.2436h2.493v-8.9802c0-3.3994-1.898-4.7592-4.108-4.7592-1.643 0-3.343 0.8216-4.929 2.238-0.652-1.5014-1.926-2.238-3.484-2.238-1.7 0-3.23 0.8499-4.618 1.983l-0.283-1.643h-2.097v13.399z" fill="#D0D0D0"></path>
                                   <path d="m153.52 33.26h2.493v-9.745c1.161-0.9915 2.464-1.7847 3.796-1.7847 1.841 0 2.238 1.4447 2.238 3.3144v8.2153h2.492v-9.0368c0-0.2266-0.028-0.4816-0.028-0.7082 1.162-0.9915 2.465-1.7847 3.796-1.7847 1.842 0 2.238 1.4447 2.238 3.2861v8.2436h2.493v-8.9802c0-3.3994-1.898-4.7592-4.108-4.7592-1.643 0-3.342 0.8216-4.929 2.238-0.651-1.5014-1.926-2.238-3.484-2.238-1.7 0-3.23 0.8499-4.618 1.983l-0.283-1.643h-2.096v13.399z" fill="#D0D0D0"></path>
                                   <path d="m187.05 27.113v-0.6232c0-4.2776-2.011-6.9689-5.524-6.9689-3.428 0-5.666 2.8612-5.666 6.9405 0 3.8244 2.04 7.0822 6.488 7.0822 1.529 0 3.144-0.425 4.391-1.2182l-0.765-1.728c-0.935 0.5099-2.04 0.9065-3.343 0.9065-2.635 0-4.193-1.8697-4.221-4.3909h8.64zm-8.64-1.8697c0.028-2.0396 1.19-3.7394 3.116-3.7394 2.011 0 2.918 1.8697 2.946 3.7394h-6.062z" fill="#D0D0D0"></path>
                                   <path d="m189.9 33.26h2.492v-9.745c1.247-1.2182 2.125-1.7281 3.06-1.7281 0.453 0 0.878 0.1133 1.303 0.34l0.878-2.2097c-0.396-0.2549-1.02-0.3966-1.586-0.3966-1.247 0-2.351 0.4816-3.768 1.983l-0.283-1.643h-2.096v13.399z" fill="#D0D0D0"></path>
                                   <path d="m204.78 33.543c1.7 0 3.286-0.5666 4.278-1.2465l-0.737-1.7564c-0.878 0.4816-1.841 0.9349-3.201 0.9349-2.578 0-4.249-1.7847-4.249-4.9292 0-2.8328 1.671-4.9575 4.419-4.9575 1.303 0 2.323 0.3683 3.229 0.9632v-2.1813c-0.793-0.4533-1.983-0.8499-3.427-0.8499-4.08 0-6.799 3.1728-6.799 7.1672 0 3.796 2.294 6.8555 6.487 6.8555z" fill="#D0D0D0"></path>
                                   <path d="m221.74 27.113v-0.6232c0-4.2776-2.012-6.9689-5.525-6.9689-3.427 0-5.665 2.8612-5.665 6.9405 0 3.8244 2.039 7.0822 6.487 7.0822 1.53 0 3.144-0.425 4.391-1.2182l-0.765-1.728c-0.935 0.5099-2.04 0.9065-3.343 0.9065-2.634 0-4.192-1.8697-4.221-4.3909h8.641zm-8.641-1.8697c0.029-2.0396 1.19-3.7394 3.116-3.7394 2.012 0 2.918 1.8697 2.947 3.7394h-6.063z" fill="#D0D0D0"></path>
                                   <path d="m40.876 37.4-0.0599-0.06c-0.8391-0.9589-2.2776-1.2586-3.2365-0.4195l-0.8991 0.5993-0.0599 0.2398-1.3186 1.1987-0.1798 0.1798c-3.2365 2.5173-7.2522 3.8359-11.568 3.8359-10.669 0-19.239-8.5708-19.239-19.239-0.05994-10.549 8.5707-19.179 19.239-19.179 4.1355 0 7.9114 1.4384 11.088 3.4763 0.06 0.05994 0.06 0.05994 0.1199 0.11987l2.3974 1.858c1.0189 0.7792 2.4574 0.5994 3.1766-0.41952l0.0599-0.05993c0.7792-1.0189 0.5994-2.4574-0.4195-3.1766l-1.0189-0.8391c-4.0756-3.4163-9.4099-5.5141-15.164-5.5141-13.126 0-23.794 10.668-23.794 23.854 0 13.126 10.668 23.734 23.794 23.734 6.3532 0 12.107-2.4574 16.362-6.533l0.4795-0.4195c0.959-0.7792 1.0788-2.2776 0.2397-3.2365z" fill="#D0D0D0"></path>
                                   <path d="m32.783 25.952-14.924 9.9493c-1.3186 0.8391-3.0567 0.4795-3.9558-0.7792-0.8391-1.3186-0.4795-3.0567 0.7792-3.9557l14.924-9.9493c1.3186-0.8391 3.0567-0.4795 3.9558 0.7791 0.899 1.3186 0.5394 3.0568-0.7792 3.9558z" fill="#9D9D9D"></path>
                                   <path d="m30.865 17.501-14.924 9.9493c-1.3186 0.8391-3.0567 0.4795-3.9557-0.7792-0.8391-1.3186-0.4795-3.0567 0.7791-3.9557l14.924-9.9493c1.3185-0.8391 3.0567-0.4795 3.9557 0.7792 0.899 1.3185 0.5394 3.1166-0.7792 3.9557z" fill="#9D9D9D"></path>
                                </svg>
                             </div>
                             <table>
                                <thead>
                                   <tr>
                                      <th>Options</th>
                                      <th>Est. Time</th>
                                   </tr>
                                </thead>
                                <tbody>
                                    ${moreshippingoptions}
                                </tbody>
                             </table>
                          </div>
                       </div>`;

    if (data.length < 2) {
        viewalltemplate = "";
    }


    let viewall = ""
    if(pageType == "cart" || pageType == "minicart"){
        viewall = `<span class="shipping-options-container">
                   Ship to: <span id="zipcode-holder"><strong>${zipcode}</strong></span> 
                  </span>
                `;
    }else{
      viewall = `<div class="shipping-options-container">
                 Ship to: <span id="zipcode-holder"><strong>${zipcode}</strong></span> 
                 <a id="fenix-toggle-zip" class="update-zip" style="" href="javascript:void(0);" onclick="_fenixshowzipcode()">
                  (Change)
                 </a> 
                 ${viewalltemplate}
              </div>
              <div id="fenix-zip" style="display: none;">
                  <input type="text" id="fenix-zip-inpt">
                  <button type="button" id="check-zip" onclick="_fenixdeliveryEstimateget('pdp')">Check Delivery</button>
              </div>
              `;
    }
     
    return viewall;
}


function _fenixdeliveryEstimateget(pageType) {
	// Request data fo PDP
	let requestData = {
	    "sessionTrackId": localStorage.getItem('fenix-sessionId'),
	    "buyerZipCode": fenixcommerceGlobal.zipcode,
	    "fenixSSID": fenixsessionid,
	    "orderId": fenixsessionid,
	    "pageType": fenixcommerceGlobal.pageType,
	    "monetaryValue": 100,
	    "sessionTrackId": fenixsessionid,
	    "_cartToken": fenixsessionid,
	    "responseFormat": "json",
	    "skus": [{
	        "sku": fenixcommerceGlobal.pdpsku,
	        "quantity": jQuery('input[name="quantity"]').val(),
	        "skuInventories": [{
	            "locationId": "manual",
	            "quantity": jQuery('input[name="quantity"]').val()
	        }]
	    }]
	};

	// Request data for cart
	let requestDataCart = {
	    "sessionTrackId": localStorage.getItem('fenix-sessionId'),
	    "buyerZipCode": fenixcommerceGlobal.zipcode,
	    "fenixSSID": fenixsessionid,
	    "orderId": fenixsessionid,
	    "pageType": fenixcommerceGlobal.pageType,
	    "monetaryValue": 100,
	    "sessionTrackId": fenixsessionid,
	    "_cartToken": fenixsessionid,
	    "responseFormat": "json",
	    "skus": JSON.parse(fenixcommerceGlobal.cartsku)
	};

    let zipcode = jQuery("#fenix-zip-inpt").val();
    if (zipcode) {
        localStorage.setItem("fenix_zipcode", zipcode);
        requestData.buyerZipCode = zipcode;
        requestDataCart.buyerZipCode = zipcode;
        fenixcommerceGlobal.zipcode = zipcode;
    }

    _setfenixvariant();


    if(pageType == "cart"){
      requestData = requestDataCart;
    }

    if(pageType == "minicart"){
      requestDataCart.pageType = "cart";
      requestDataCart.skus = JSON.parse(jQuery("#fenixskucart_minicart").val());
      requestData = requestDataCart;
    }


    fenixcommerceGlobal.ajaxrequestcalled = jQuery.ajax({
        url: fenixcommerceGlobal.apiurl+'/v2/deliveryestimates',
        type: "POST",
        headers: {
            tenantId: fenixcommerceGlobal.tenantId,
            'Content-Type': 'application/json'
        },
        data: JSON.stringify(requestData),
        beforeSend: function() {
          if(fenixcommerceGlobal.ajaxrequestcalled){
              fenixcommerceGlobal.ajaxrequestcalled.abort();
          }
        },
        success: function(data) {
            fenixcommerceGlobal.ajaxrequestcalled = null;
            let htmlposition = jQuery("#fenixfixddelivery_woocom");

            let htmlpositionminicart = jQuery("#fenixfixddelivery_woocom_minicart")
            
            jQuery("#fenix-zip").hide();

            if (data !== undefined && data !== "" && data.length > 0) {
                let responsedata = data[0].response;

                responsedata = fenixcommerceGlobal.trucksvg + " " + responsedata;
                htmlposition.show();
                htmlposition.html(responsedata + _fenixsetviewalloptions(requestData.buyerZipCode, data, pageType));
                  
                if(pageType == "minicart"){
                  htmlpositionminicart.show();
                  htmlpositionminicart.html(responsedata + _fenixsetviewalloptions(requestData.buyerZipCode, data, pageType));
                }

            }
        },
        error: function(e) {
            console.log(e);
        }
    });
}

function _fenixgetstoreinfo(){
  let storefetchurl = fenixcommerceGlobal.apiurl+"/v1/";
  storefetchurl = storefetchurl+window.location.hostname+"/storeinfo";
  
  jQuery.ajax({
      type: "GET",
      url: storefetchurl,
      async: "true",
      dataType: "json"
  })
  .done(function(data) {
      if(data && data.tenantId){
          fenixcommerceGlobal.tenantId = data.tenantId;
          fenixcommerceGlobal.storeinfo = data;
          localStorage.setItem("fenix-tenantId", data.tenantId);
          localStorage.setItem("fenix-storeinfo", JSON.stringify(data));
          _fenixipLookUp();
      }
  })
  .fail(function(error) {

  });  
}

function isValidUSZip(sZip) {
  return /^\d{5}(-\d{4})?$/.test(sZip);
}

function _fenixipLookUp() {
    jQuery.ajax('https://ipapi.co/json').then(function success(response) {
        ipLocation = response.postal;
        localStorage.setItem("fenix_zipcode", ipLocation);
        fenixcommerceGlobal.zipcode = ipLocation;
        if (isValidUSZip(ipLocation)) {
            _fenixdeliveryEstimateget("pdp");
        }
    }, function fail(data, status) {
       
    })
}


if( fenixcommerceGlobal.tenantId && (fenixcommerceGlobal.pageType == "pdp" || fenixcommerceGlobal.pageType == "cart")){
  _fenixdeliveryEstimateget(fenixcommerceGlobal.pageType);  
}else if(fenixcommerceGlobal.pageType == "pdp"){
  _fenixgetstoreinfo();
}



// Set fenix variant SKU 
function _setfenixvariant(){
  	let productvars = JSON.parse(fenixcommerceGlobal.variations);
	let currentvariant = jQuery("input[name='variant_id']").val(); 
	jQuery.each(productvars, function( index, value ) {
	  if( currentvariant == value.variant_id ){
	    fenixcommerceGlobal.pdpsku = value.sku;
	  }
	});
}

// Product form on change events 
let fenixformdata =  jQuery(fenixcommerceGlobal.fenixformonchange).serialize();
jQuery(fenixcommerceGlobal.fenixformonchange).on("change, click", function(){
    let newfenixformdata = jQuery(fenixcommerceGlobal.fenixformonchange).serialize();
    if(fenixformdata != newfenixformdata){
      _setfenixvariant();
      _fenixdeliveryEstimateget("pdp");
    }  
    fenixformdata = newfenixformdata;
});



jQuery(".header-btn.cart-btn").on("click", function(){
  if(window.location.pathname !== "/cart" || window.location.pathname !== "/cart/"){
    if( jQuery("#fenixskucart_minicart").val() !== undefined && 
        JSON.parse(jQuery("#fenixskucart_minicart").val()).length > 0 ){
      _fenixdeliveryEstimateget("minicart");
    }
  }
});

jQuery(".bc-btn--add_to_cart").on("click", function(){
  if(window.location.pathname !== "/cart" || window.location.pathname !== "/cart/"){
    setTimeout(function(){ 
        // Cart already has 1 product. 
      if(jQuery("#fenixskucart_minicart").val() !== undefined && jQuery("#fenixskucart_minicart").val() !== ""){
        let carthasdata = JSON.parse(jQuery("#fenixskucart_minicart").val());
        jQuery.each(carthasdata, function(index, value) {
          if( value.sku == fenixcommerceGlobal.pdpsku ){
            carthasdata[index].quantity = parseInt(value.quantity) + parseInt(jQuery('input[name="quantity"]').val());
            jQuery("#fenixskucart_minicart").val(JSON.stringify(carthasdata));
          }
        });
      }else{
       // cart is empty make a new object.
        let newcart = [];
        let product = {};
        product["sku"] = fenixcommerceGlobal.pdpsku;
        product["quantity"] = jQuery('input[name="quantity"]').val();
        product["skuInventories"] = [];

        let tempsku = {}
        tempsku["locationId"] = "manual";
        tempsku["quantity"] = jQuery('input[name="quantity"]').val();
        
        product["skuInventories"].push(tempsku);
        newcart.push(product);
        jQuery("#fenixskucart_minicart").val(JSON.stringify(newcart));
      } 
      
      _fenixdeliveryEstimateget("minicart");

    }, 4000);


  }
});



