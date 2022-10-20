$(function () {
	$("#itemPrice").maskMoney({ thousands: ",", decimal: ".", allowZero: true });
	$("#disco").maskMoney({ thousands: ",", decimal: ".", allowZero: true });
	$("#okr").maskMoney({ thousands: ",", decimal: ".", allowZero: true });
	$("#custCode").select2({
		theme: "bootstrap4",
		width: "100%",
		ajax: {
			dataType: "JSON",
			url: site + "sale/get_all_cust",
			data: function (params) {
				return {
					key: params.term,
				};
			},
			processResults: function (data) {
				var results = [];

				$.each(data, function (index, item) {
					results.push({
						id: item.id,
						text: item.kode,
					});
				});
				return {
					results: results,
				};
			},
		},
	});

	$("#items").select2({
		theme: "bootstrap4",
		width: "100%",
		ajax: {
			dataType: "JSON",
			url: site + "sale/get_all_item",
			data: function (params) {
				return {
					key: params.term,
				};
			},
			processResults: function (data) {
				var results = [];

				$.each(data, function (index, item) {
					results.push({
						id: item.id,
						text: item.kode + " - " + item.nama + " - " + item.harga,
					});
				});
				return {
					results: results,
				};
			},
		},
	});
	$("#custCode").on("change", function () {
		$.ajax({
			type: "POST",
			url: site + "sale/get_cust/" + $(this).val(),
			dataType: "JSON",
			success: function (data) {
				$("#custName").val(data.name);
				$("#custTelp").val(data.telp);
			},
		});
	});

	$("#custCode").on("change", function () {
		$.ajax({
			type: "POST",
			url: site + "sale/get_cust/" + $(this).val(),
			dataType: "JSON",
			success: function (data) {
				$("#custName").val(data.name);
				$("#custTelp").val(data.telp);
			},
		});
	});

	$.ajax({
		type: "POST",
		url: site + "sale/get_no_trans/",
		dataType: "JSON",
		success: function (data) {
			$("#noTrans").val(data);
			// alert();
		},
	});

	var totbar = function () {
		var arrayTotal = $("#SaleRow tr")
			.map(function () {
				return $(this).children("td").eq(9).children().val();
			})
			.get();

		var disco = $("#disco").val();
		var okr = $("#okr").val();

		$.ajax({
			url: site + "sale/totbar_count/",
			type: "POST",
			dataType: "JSON",
			data: { arrayTot: arrayTotal, disco: disco, okr: okr },
			success: function (data) {
				$("#subTot").val(data.subtot);
				$("#totbar").val(data.totbar);
				$("#SaleFormModal").modal("hide");
			},
		});
	};

	var addSale = $("#SaleFormModal form").validate({
		submitHandler: function (form) {
			$.ajax({
				url: site + "sale/sale_per_row",
				type: "POST",
				dataType: "JSON",
				data: $(form).serialize(),
				success: function (response) {
					if (response) {
						// if ($('#SaleFormModal form').attr('data-type') == 'SaleEdit') {
						//     // console.log($("tr[data-id='" +  response.id + "']"));
						//     $("tr[data-id='" +  response.currId + "']").remove();
						//     // alert("bajingan");
						// }

						if (response.no == "") {
							//insert
							// alert("kosong");
							// $('#disco').val("0.00");
							// $('#okr').val("0.00");
							$("#SaleRow").append(response.html);
						} else {
							// $('#SaleRow').append(response.html);
							// alert(response.currId);
							$("tr[data-no='" + response.no + "']").replaceWith(response.html);
							// $('#SaleRow').append(response.html);
						}
						var no = 1;
						$("#SaleRow tr").each(function (i) {
							$(this).attr("data-no", no);
							$(this).children("td").eq(1).html(no);
							no++;
						});

						totbar();

						$(".btn-del").on("click", function (e) {
							e.preventDefault();
							$(this).parents("tr").remove();
							totbar();
						});
					}
				},
			});
		},
	});

	$("#items").on("change", function () {
		if ($(this).val() == null) {
			$("#SaleFormModal").find("button.btn-primary").prop("disabled", true);
		} else {
			$("#SaleFormModal").find("button.btn-primary").prop("disabled", false);
		}
	});

	$("#SaleFormModal").on("hidden.bs.modal", function () {
		addSale.resetForm();
		$(this).find("form").trigger("reset");
		$("#items").val(null).trigger("change");
	});

	$("#SaleFormModal").on("shown.bs.modal", function (e) {
		var dataType = $(e.relatedTarget).data("type");

		var dataNo = "";
		var dataId = "";
		var dataQty = "";
		var dataDiscPerc = "";
		if (dataType == "SaleEdit") {
			dataNo = $(e.relatedTarget).parents("tr").data("no");
			dataId = $(e.relatedTarget).data("id");
			dataQty = $(e.relatedTarget)
				.parents("tr")
				.find("input[name='qty[]']")
				.val();
			dataDiscPerc = $(e.relatedTarget)
				.parents("tr")
				.find("input[name='discPerc[]']")
				.val();
		}
		var dataType = $(e.relatedTarget).data("type");
		var modal = $(e.currentTarget);

		$.ajax({
			type: "POST",
			url: site + "sale/get_form_data/" + dataType,
			dataType: "JSON",
			data: { no: dataNo, id: dataId, qty: dataQty, discPerc: dataDiscPerc },
			success: function (data) {
				modal.find(".modal-title").html(data.title);
				modal.find("form").attr("data-type", dataType);
				modal.find("#no").val(data.no);
				if (dataType == "SaleEdit") {
					$("#items").val(data.id).trigger("change");
					$("#qty").val(data.qty);
					$("#discPerc").val(data.discPerc);
				} else {
					$("#items").val(null).trigger("change");
					$("#qty").val(1);
					$("#discPerc").val(0);
				}
			},
		});
	});

	$("#disco, #okr").keyup(function () {
		var subtot = parseInt($("#subTot").val().replace(/,/g, ""));
		var disco = parseInt($("#disco").val().replace(/,/g, ""));

		if (disco > subtot) {
			$("#disco").val($("#subTot").val());
		}
		totbar();
	});

	// $('#btnReset').click(function(e) {
	//     e.preventDefault();
	//     location.reload();
	// });

	// var saveSale = $('#ItemFormModal form').validate({
	//     errorClass: 'invalid-feedback',
	//     highlight: function(element) {
	// 		$(element).removeClass("error");
	// 	},
	//     rules: {
	//         itemCode: {
	//             required: true,
	//         },
	//         itemName: {
	//             required: true,
	//         },
	//         // itemPrice: {
	//         //     required: true,
	//         // },

	//     },
	//     submitHandler: function(form) {
	//         $.ajax({
	//             url: site + "item/item_add",
	//             type: "POST",
	//             data: $(form).serialize(),
	//             success: function(response) {
	//                 if (response) {
	//                     alert("ok");
	//                 }
	//             }
	//         });
	//     }
	// });

	$("#saleSubmit").validate({
		submitHandler: function (form) {
			if (
				!$(form.date).val() ||
				!$(form.custCode).val() ||
				$(form.subTot).val() == "0.00"
			) {
				swal("Data belum bisa disimpan karena ada data yg belum di isi!!!");
			} else {
				swal({
					title: "Konfirmasi",
					text: "Apkah yakin untuk menyimpannya?",
					icon: "info",
					buttons: ["Tidak", "Ya"],
					dangerMode: true,
				}).then((ok) => {
					if (ok) {
						$.ajax({
							url: site + "sale/sale_submit",
							type: "POST",
							data: $(form).serialize(),
							success: function (response) {
								if (response) {
									swal("Data sudah tersimpan", {
										icon: "success",
									}).then(() => {
										window.location.href = site;
									});
								}
							},
						});
					}
				});
			}
		},
	});

	$("#tbList").DataTable({
		processing: true,
		serverSide: true,
		order: [],

		ajax: {
			url: site + "dashboard/get_data_trans",
			type: "POST",
		},
		autoWidth: false,
		columnDefs: [
			{
				// width: "100%",
				targets: [0, 1, 3, 6, 7],
				orderable: false,
			},
		],
	});
});
