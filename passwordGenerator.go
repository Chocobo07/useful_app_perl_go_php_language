package main

import (
	"crypto/rand"
	"fmt"
	"math/big"
)

const charset = "qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890!@#$%^&*()_+"

func GeneratePassword(length int) (string, error) {
	if length <= 0 {
		return "", fmt.Errorf("Invalid password length")
	}

	password := make([]byte, length)
	for i := range password {
		randIndex, err := rand.Int(rand.Reader, big.NewInt(int64(len(charset))))
		if err != nil {
			return "", err
		}
		password[i] = charset[randIndex.Int64()]
	}

	return string(password), nil
}

func main() {
	var length int
	fmt.Print("Enter password length: ")
	fmt.Scan(&length)

	password, err := GeneratePassword(length)
	if err != nil {
		fmt.Println("Error:", err)
		return
	}

	fmt.Println("Generated password:", password)
}
