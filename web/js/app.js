new Vue({
  el: "#app",
  data: {
    showStartButton: true,
    isFormOpen: false,
    hasSentRequest: false,
    currentStep: 1,
    selectedMonth: "",
    selectedType: "",
    selectedTonnage: "",
    months: [],
    types: [],
    tonnages: [],
    prices: null,
    calculatedPrice: null,
    showErrorParams: false,
    showErrorModal: false,
    errorMessage: "",
    priceArray: [],
  },
  methods: {
    async fetchPrice() {
      try {
        if (this.selectedMonth && this.selectedTonnage && this.selectedType) {
          const url = new URL("api/v1/prices", window.location.origin);
          url.searchParams.append("month", this.selectedMonth);
          url.searchParams.append("tonnage", this.selectedTonnage);
          url.searchParams.append("type", this.selectedType);

          const response = await fetch(url);
          const data = await response.json();

          this.calculatedPrice = data.price;
          this.prices = data.price_list;

          if (this.calculatedPrice == null) {
            this.hasSentRequest = true;
            this.showErrorModal = true;
          }
          for (
            let monthIndex = 0;
            monthIndex < this.months.length;
            monthIndex++
          ) {
            const month = this.months[monthIndex];

            for (
              let tonnageIndex = 0;
              tonnageIndex < this.tonnages.length;
              tonnageIndex++
            ) {
              const tonnage = this.tonnages[tonnageIndex];

              const price =
                this.prices[this.selectedType]?.[month]?.[tonnage] || "-";
              this.priceArray.push(price);
            }
          }

          fetch("/api/v1/history", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
            },
            body: JSON.stringify({
              month_name: this.selectedMonth,
              raw_type_name: this.selectedType,
              tonnage_value: this.selectedTonnage,
              price: this.calculatedPrice,
            }),
          })
            .then((response) => {
              if (response.ok) {
                console.log("Данные успешно сохранены");
              } else {
                console.error("Ошибка при сохранении данных:", response.status);
              }
            })
            .catch((error) => {
              console.error("Произошла ошибка:", error);
            });
        } else {
          const missingParams = [];
          if (!this.selectedMonth) missingParams.push("месяц");
          if (!this.selectedTonnage) missingParams.push("тоннаж");
          if (!this.selectedType) missingParams.push("тип сырья");

          this.errorMessage = `Для продолжения выберите следующие параметры: ${missingParams.join(
            ", "
          )}`;
          this.showErrorParams = true;
        }
      } catch (error) {
        console.error("Ошибка при получении данных: " + error);
      }
    },
    reset() {
      this.calculatedPrice = null;
      this.isFormOpen = true;
      this.currentStep = 1;
      this.selectedMonth = "";
      this.selectedType = "";
      this.selectedTonnage = "";
      this.priceArray = [];
      this.hasSentRequest = false;
    },

    closeErrorParams() {
      this.showErrorParams = false;
    },

    closeErrorModal() {
      this.showErrorModal = false;
      this.reset();
    },

    openForm() {
      this.isFormOpen = true;
      this.showStartButton = false;
      document.getElementById("form-button").scrollIntoView();
    },
    nextStep() {
      this.currentStep++;
    },
    prevStep() {
      this.currentStep--;
    },

    async fetchMonths() {
      try {
        const response = await fetch("/api/v1/months");
        const data = await response.json();
        this.months = data;
      } catch (error) {
        console.error("Ошибка при получении данных:", error);
      }
    },
    async fetchTypes() {
      try {
        const response = await fetch("/api/v1/types");
        const data = await response.json();
        this.types = data;
      } catch (error) {
        console.error("Ошибка при получении данных:", error);
      }
    },
    async fetchTonnages() {
      try {
        const response = await fetch("/api/v1/tonnages");
        const data = await response.json();
        this.tonnages = data;
      } catch (error) {
        console.error("Ошибка при получении данных:", error);
      }
    },
  },
  mounted() {
    this.fetchMonths();
    this.fetchTypes();
    this.fetchTonnages();
  },
});
