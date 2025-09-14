"use client";
import ArticleFacet from "./ArticleFacet";

export default function DuctFacet() {
  const category = process.env.NEXT_PUBLIC_DUCT_CATEGORY_ID || "";
  return (
    <ArticleFacet
      category={category}
      selectionKey="duct"
      title="Abluftschlauch"
      queryKey={["ductArticles"]}
    />
  );
}
