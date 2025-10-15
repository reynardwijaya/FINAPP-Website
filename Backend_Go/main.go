package main

import (
	"bytes"
	"database/sql"
	"encoding/json"
	"fmt"
	"io"
	"log"
	"net/http"

	_ "github.com/go-sql-driver/mysql" // MySQL driver
)

// Database connection details
const (
	dbUser       = "root" // Default XAMPP MariaDB user
	dbPassword   = ""     // Default XAMPP MariaDB password (empty)
	dbHost       = "127.0.0.1"
	dbPort       = "3306"
	dbName       = "finapp"
	geminiAPIKey = "AIzaSyAAjX4SmTRKANTs3-E0MEqHZockYoMwF4s"
	geminiURL    = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=" + geminiAPIKey
)

var db *sql.DB

func main() {
	// Initialize database connection
	var err error
	dataSourceName := fmt.Sprintf("%s:%s@tcp(%s:%s)/%s", dbUser, dbPassword, dbHost, dbPort, dbName)
	db, err = sql.Open("mysql", dataSourceName)
	if err != nil {
		log.Fatalf("Error opening database: %v", err)
	}
	defer db.Close()

	// Ping the database to verify the connection
	err = db.Ping()
	if err != nil {
		log.Fatalf("Error connecting to the database: %v", err)
	}

	fmt.Println("Successfully connected to the database!")

	// Define a simple API endpoint
	http.HandleFunc("/api/hello", helloHandler)

	// Placeholder for Gemini AI integration
	http.HandleFunc("/api/analyze", analyzeHandler)

	fmt.Println("Server listening on port 8080...")
	log.Fatal(http.ListenAndServe(":8080", nil))
}

func helloHandler(w http.ResponseWriter, r *http.Request) {
	fmt.Fprintf(w, "Hello from GoLang Backend!")
}

func analyzeHandler(w http.ResponseWriter, r *http.Request) {
	// Set CORS headers
	w.Header().Set("Access-Control-Allow-Origin", "*")
	w.Header().Set("Access-Control-Allow-Methods", "POST, GET, OPTIONS, PUT, DELETE")
	w.Header().Set("Access-Control-Allow-Headers", "Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization")

	// Handle preflight OPTIONS request
	if r.Method == "OPTIONS" {
		w.WriteHeader(http.StatusOK)
		return
	}

	if r.Method != http.MethodPost {
		http.Error(w, "Only POST requests are allowed", http.StatusMethodNotAllowed)
		return
	}

	var data struct {
		Income  float64 `json:"income"`
		Expense float64 `json:"expense"`
	}

	err := json.NewDecoder(r.Body).Decode(&data)
	if err != nil {
		http.Error(w, "Invalid request body", http.StatusBadRequest)
		return
	}

	prompt := fmt.Sprintf(
		"Analisis singkat keuangan UMKM:\n\n"+
			"💰 Pendapatan: Rp%.2f | 💸 Pengeluaran: Rp%.2f\n\n"+
			"Berikan analisis singkat dengan format berikut:\n\n"+
			"🎯 STATUS KEUANGAN:\n"+
			"[Sehat/Perlu Perhatian/Kritis] - [Alasan dalam 1 kalimat]\n\n"+
			"⚠️ POIN KRUSIAL:\n"+
			"[1 masalah atau peluang utama yang perlu segera ditindaklanjuti]\n\n"+
			"💡 SOLUSI CEPAT:\n"+
			"[1 tindakan konkret yang bisa langsung diterapkan]\n\n"+
			"📚 REFERENSI UMKM:\n"+
			"Pilih 1 artikel/video terpercaya khusus UMKM tentang:\n"+
			"- Manajemen kas untuk UMKM\n"+
			"- Strategi peningkatan profit UMKM\n"+
			"- Tips efisiensi biaya operasional\n"+
			"- Perencanaan keuangan bisnis kecil\n\n"+
			"Note: Berikan respons yang sangat singkat dan langsung ke inti masalah.",
		data.Income, data.Expense,
	)

	reqBody, err := json.Marshal(map[string]interface{}{
		"contents": []map[string]interface{}{
			{
				"parts": []map[string]string{
					{"text": prompt},
				},
			},
		},
	})
	if err != nil {
		log.Printf("Error marshaling request body: %v", err)
		http.Error(w, "Internal server error", http.StatusInternalServerError)
		return
	}

	resp, err := http.Post(geminiURL, "application/json", bytes.NewBuffer(reqBody))
	if err != nil {
		log.Printf("Error making request to Gemini API: %v", err)
		http.Error(w, "Failed to connect to AI service", http.StatusInternalServerError)
		return
	}
	defer resp.Body.Close()

	body, err := io.ReadAll(resp.Body)
	if err != nil {
		log.Printf("Error reading Gemini API response: %v", err)
		http.Error(w, "Failed to read AI service response", http.StatusInternalServerError)
		return
	}

	if resp.StatusCode != http.StatusOK {
		log.Printf("Gemini API returned non-OK status: %d - %s", resp.StatusCode, string(body))
		http.Error(w, "AI service returned an error", http.StatusInternalServerError)
		return
	}

	var geminiResponse struct {
		Candidates []struct {
			Content struct {
				Parts []struct {
					Text string `json:"text"`
				}
			}
		}
	}

	err = json.Unmarshal(body, &geminiResponse)
	if err != nil {
		log.Printf("Error unmarshaling Gemini API response: %v - %s", err, string(body))
		http.Error(w, "Failed to parse AI service response", http.StatusInternalServerError)
		return
	}

	if len(geminiResponse.Candidates) > 0 && len(geminiResponse.Candidates[0].Content.Parts) > 0 {
		fmt.Fprintf(w, geminiResponse.Candidates[0].Content.Parts[0].Text)
	} else {
		fmt.Fprintf(w, "No AI analysis available.")
	}
}
