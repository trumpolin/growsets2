"use client";
import ArticleFacet from "./ArticleFacet";

export default function DuctFacet() {
  return (
    <ArticleFacet
      category="duct"
      selectionKey="duct"
      title="Abluftschlauch"
      queryKey={["ductArticles"]}
    />
  );
}
